<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Scrape the latest USD to IDR rate from an external website.
     *
     * @return int
     */
    private function scrape()
    {
        $client = new Client();

        // URL target untuk scraping
        $url = 'https://kursdollar.org/real-time/USD/';
        // Mengirim permintaan GET ke halaman web
        $crawler = $client->request('GET', $url);

        // Mencari elemen dengan selector CSS yang tepat
        $value = $crawler->filter('.in_table tr:nth-child(3) > td:first-child')->text();

        // Menghilangkan titik sebagai pemisah ribuan dan mengganti koma dengan titik jika ada desimal
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        // Mengonversi nilai tukar menjadi float
        $floatValue = (float) $value;

        // Mengonversi nilai tukar menjadi integer (dengan pembulatan)
        $intValue = (int) round($floatValue);

        // Mengembalikan nilai tukar dalam format integer
        return $intValue;
    }

    /**
     * Get the latest USD to IDR rate, utilizing caching to prevent excessive scraping.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestRate()
    {
        // Cache rate untuk 10 menit
        $rate = Cache::remember('usd_to_idr_rate', 10, function () {
            return $this->scrape();
        });

        return response()->json(['rate' => $rate]);
    }

    /**
     * Helper function to parse formatted number strings into numeric values.
     *
     * @param string|null $numberString
     * @return float
     */
    private function parseFormattedNumber($numberString)
    {
        if (!$numberString) {
            return 0.0;
        }

        // Hapus titik sebagai pemisah ribuan dan ganti koma dengan titik jika ada desimal
        $cleanString = str_replace('.', '', $numberString);
        $cleanString = str_replace(',', '.', $cleanString);

        return (float) $cleanString;
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Mengonversi data yang diformat menjadi numerik
        $request->merge([
            'rateIDR' => $this->parseFormattedNumber($request->rateIDR),
            'ppnAmount' => $this->parseFormattedNumber($request->ppnAmount),
            'totalAmount' => $this->parseFormattedNumber($request->totalAmount),
        ]);

        // Mengonversi array itemUnitPrice dan itemTotal menjadi numerik
        if ($request->has('itemUnitPrice') && is_array($request->itemUnitPrice)) {
            $itemUnitPrice = array_map(function ($value) {
                return $this->parseFormattedNumber($value);
            }, $request->itemUnitPrice);
            $request->merge(['itemUnitPrice' => $itemUnitPrice]);
        }

        if ($request->has('itemTotal') && is_array($request->itemTotal)) {
            $itemTotal = array_map(function ($value) {
                return $this->parseFormattedNumber($value);
            }, $request->itemTotal);
            $request->merge(['itemTotal' => $itemTotal]);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'companyName' => 'required|string|max:255',
            'clientName' => 'required|string|max:255',
            'clientJobTitle' => 'nullable|string|max:255',
            'clientTelephone' => 'nullable|string|max:20',
            'clientEmail' => 'required|email|max:255',
            'npwp' => 'nullable|string|max:50',
            'rateIDR' => 'required|numeric',
            'clientAddress' => 'required|string',
            'paymentMethod' => 'required|in:Manual Transfer,Xendit Transfer',
            'ppnRate' => 'nullable|in:0,11,12',
            'ppnAmount' => 'nullable|numeric',
            'totalAmount' => 'required|numeric',
            'paymentStatus' => 'required|in:Unpaid,Paid',
            'notes' => 'nullable|string',
            'itemDescription' => 'required|array|min:1',
            'itemDescription.*' => 'required|string',
            'itemQuantity' => 'required|array|min:1',
            'itemQuantity.*' => 'required|integer|min:1',
            'itemUnitPrice' => 'required|array|min:1',
            'itemUnitPrice.*' => 'required|numeric|min:0',
            'itemTotal' => 'required|array|min:1',
            'itemTotal.*' => 'required|numeric|min:0',
        ], [
            'ppnRate.in' => 'The selected PPN rate is invalid.',
            'paymentMethod.in' => 'The selected payment method is invalid.',
            'paymentStatus.in' => 'The selected payment status is invalid.',
            // Tambahkan pesan kesalahan lain sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi total amount sesuai dengan jumlah item dan PPN
        $calculatedSubtotal = 0;
        foreach ($request->itemDescription as $index => $description) {
            $quantity = $request->itemQuantity[$index];
            $unitPrice = $request->itemUnitPrice[$index];
            $calculatedSubtotal += $quantity * $unitPrice;
        }

        $ppnRate = $request->input('ppnRate', 0);
        $ppnAmount = $request->input('ppnAmount', 0);

        // Hitung subtotal + PPN
        $calculatedTotal = $calculatedSubtotal + $ppnAmount;

        // Periksa apakah total amount sesuai
        if (round($calculatedTotal, 2) != round($request->totalAmount, 2)) {
            return redirect()->back()->withErrors(['totalAmount' => 'Total amount tidak sesuai dengan jumlah item dan PPN.'])->withInput();
        }

        // Membuat nomor invoice unik menggunakan transaksi dan locking untuk mencegah duplikasi
        DB::beginTransaction();
        try {
            $lastInvoice = Invoice::lockForUpdate()->latest('id')->first();
            $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
            $invoiceNumber = 'INV' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Simpan data Invoice
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'invoice_date' => now(),
                'due_date' => now()->addDays(14), // Misalnya due date 14 hari setelah invoice date
                'client_name' => $request->clientName,
                'company_name' => $request->companyName,
                'client_job_title' => $request->clientJobTitle,
                'client_telephone' => $request->clientTelephone,
                'client_email' => $request->clientEmail,
                'npwp' => $request->npwp,
                'rate_idr' => $request->rateIDR,
                'client_address' => $request->clientAddress,
                'payment_method' => $request->paymentMethod,
                'ppn_rate' => $ppnRate,
                'ppn_amount' => $ppnAmount,
                'total_amount' => $request->totalAmount,
                'payment_status' => $request->paymentStatus,
                'notes' => $request->notes,
            ]);

            // Simpan Item Invoice
            foreach ($request->itemDescription as $index => $description) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $description,
                    'quantity' => $request->itemQuantity[$index],
                    'unit_price' => $request->itemUnitPrice[$index],
                    'total' => $request->itemTotal[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('invoice.detail', $invoice->id)->with('success', 'Invoice berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            // Log error jika perlu
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan invoice.'])->withInput();
        }
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Invoice ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        // Mengonversi data yang diformat menjadi numerik
        $request->merge([
            'rateIDR' => $this->parseFormattedNumber($request->rateIDR),
            'ppnAmount' => $this->parseFormattedNumber($request->ppnAmount),
            'totalAmount' => $this->parseFormattedNumber($request->totalAmount),
        ]);

        // Mengonversi array itemUnitPrice dan itemTotal menjadi numerik
        if ($request->has('itemUnitPrice') && is_array($request->itemUnitPrice)) {
            $itemUnitPrice = array_map(function ($value) {
                return $this->parseFormattedNumber($value);
            }, $request->itemUnitPrice);
            $request->merge(['itemUnitPrice' => $itemUnitPrice]);
        }

        if ($request->has('itemTotal') && is_array($request->itemTotal)) {
            $itemTotal = array_map(function ($value) {
                return $this->parseFormattedNumber($value);
            }, $request->itemTotal);
            $request->merge(['itemTotal' => $itemTotal]);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'companyName' => 'required|string|max:255',
            'clientName' => 'required|string|max:255',
            'clientJobTitle' => 'nullable|string|max:255',
            'clientTelephone' => 'nullable|string|max:20',
            'clientEmail' => 'required|email|max:255',
            'npwp' => 'nullable|string|max:50',
            'rateIDR' => 'required|numeric',
            'clientAddress' => 'required|string',
            'paymentMethod' => 'required|in:Manual Transfer,Xendit Transfer',
            'ppnRate' => 'nullable|in:0,11,12',
            'ppnAmount' => 'nullable|numeric',
            'totalAmount' => 'required|numeric',
            'paymentStatus' => 'required|in:Unpaid,Paid',
            'notes' => 'nullable|string',
            'itemDescription' => 'required|array|min:1',
            'itemDescription.*' => 'required|string',
            'itemQuantity' => 'required|array|min:1',
            'itemQuantity.*' => 'required|integer|min:1',
            'itemUnitPrice' => 'required|array|min:1',
            'itemUnitPrice.*' => 'required|numeric|min:0',
            'itemTotal' => 'required|array|min:1',
            'itemTotal.*' => 'required|numeric|min:0',
        ], [
            'ppnRate.in' => 'The selected PPN rate is invalid.',
            'paymentMethod.in' => 'The selected payment method is invalid.',
            'paymentStatus.in' => 'The selected payment status is invalid.',
            // Tambahkan pesan kesalahan lain sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi total amount sesuai dengan jumlah item dan PPN
        $calculatedSubtotal = 0;
        foreach ($request->itemDescription as $index => $description) {
            $quantity = $request->itemQuantity[$index];
            $unitPrice = $request->itemUnitPrice[$index];
            $calculatedSubtotal += $quantity * $unitPrice;
        }

        $ppnRate = $request->input('ppnRate', 0);
        $ppnAmount = $request->input('ppnAmount', 0);

        // Hitung subtotal + PPN
        $calculatedTotal = $calculatedSubtotal + $ppnAmount;

        // Periksa apakah total amount sesuai
        if (round($calculatedTotal, 2) != round($request->totalAmount, 2)) {
            return redirect()->back()->withErrors(['totalAmount' => 'Total amount tidak sesuai dengan jumlah item dan PPN.'])->withInput();
        }

        // Mulai transaksi untuk mencegah data tidak konsisten
        DB::beginTransaction();
        try {
            // Update data Invoice
            $invoice->update([
                'invoice_number' => $invoice->invoice_number, // Nomor invoice tetap
                'invoice_date' => $invoice->invoice_date, // Tanggal invoice tetap
                'due_date' => $invoice->due_date, // Due date tetap atau bisa diubah sesuai kebutuhan
                'client_name' => $request->clientName,
                'company_name' => $request->companyName,
                'client_job_title' => $request->clientJobTitle,
                'client_telephone' => $request->clientTelephone,
                'client_email' => $request->clientEmail,
                'npwp' => $request->npwp,
                'rate_idr' => $request->rateIDR,
                'client_address' => $request->clientAddress,
                'payment_method' => $request->paymentMethod,
                'ppn_rate' => $ppnRate,
                'ppn_amount' => $ppnAmount,
                'total_amount' => $request->totalAmount,
                'payment_status' => $request->paymentStatus,
                'notes' => $request->notes,
            ]);

            // Hapus semua item yang ada
            $invoice->items()->delete();

            // Simpan kembali item invoice yang baru
            foreach ($request->itemDescription as $index => $description) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $description,
                    'quantity' => $request->itemQuantity[$index],
                    'unit_price' => $request->itemUnitPrice[$index],
                    'total' => $request->itemTotal[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('invoice.detail', $invoice->id)->with('success', 'Invoice berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            // Log error jika perlu
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui invoice.'])->withInput();
        }
    }

    /**
     * Display the specified invoice.
     *
     * @param  int  $id Invoice ID
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        // Menghitung Subtotal
        $subtotal = $invoice->total_amount - $invoice->ppn_amount;
        // Menghitung Grand Total
        $grandTotal = $invoice->total_amount;
        return view('pdf.template-invoice', compact('invoice', 'subtotal', 'grandTotal'));
    }

    /**
     * Display a listing of the invoices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Filter berdasarkan periode jika diperlukan
        $period = $request->get('period', 'year');
        $query = Invoice::query();

        switch ($period) {
            case 'year':
                $query->whereYear('invoice_date', now()->year);
                break;
            case 'month':
                $query->whereMonth('invoice_date', now()->month);
                break;
            case 'week':
                $query->whereBetween('invoice_date', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'today':
                $query->whereDate('invoice_date', now()->toDateString());
                break;
            case 'last_month':
                $query->whereMonth('invoice_date', now()->subMonth()->month)
                    ->whereYear('invoice_date', now()->subMonth()->year);
                break;
                // Tambahkan opsi lain jika diperlukan
            default:
                $query->whereYear('invoice_date', now()->year);
                break;
        }

        $invoices = $query->latest('invoice_date')->paginate(10);

        // Menghitung statistik jika diperlukan
        $totalInvoicesIssuedThisPeriod = $query->count();
        $totalInvoicesPaidThisPeriod = $query->where('payment_status', 'Paid')->count();
        $totalInvoicesUnpaidThisPeriod = $query->where('payment_status', 'Unpaid')->count();

        return view('invoice.index', compact(
            'invoices',
            'period',
            'totalInvoicesIssuedThisPeriod',
            'totalInvoicesPaidThisPeriod',
            'totalInvoicesUnpaidThisPeriod'
        ));
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param  int  $id Invoice ID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        // Konversi atribut numerik menjadi integer
        $invoice->rate_idr = intval(round($invoice->rate_idr));
        $invoice->total_amount = intval(round($invoice->total_amount));
        $invoice->ppn_amount = intval(round($invoice->ppn_amount));

        // Konversi atribut numerik pada setiap item invoice
        foreach ($invoice->items as $item) {
            $item->unit_price = intval(round($item->unit_price));
            $item->total = intval(round($item->total));
        }

        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  int  $id Invoice ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil dihapus.');
    }


    public function downloadPdf($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        // Menghitung Subtotal
        $subtotal = $invoice->total_amount - $invoice->ppn_amount;
        // Menghitung Grand Total
        $grandTotal = $invoice->total_amount;
        // Pilih view yang akan digunakan untuk PDF. Misalnya, 'invoice.detail'
        $pdf = PDF::loadView('pdf.template-invoice', compact('invoice', 'subtotal', 'grandTotal'));

        // Anda dapat mengatur opsi tambahan seperti paper size dan orientation
        $pdf->setPaper('A4', 'portrait');

        // Nama file yang akan diunduh
        $fileName = 'Invoice_' . $invoice->invoice_number . '.pdf';

        return $pdf->download($fileName);
    }
}
