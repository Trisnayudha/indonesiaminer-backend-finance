<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    /**
     * Menampilkan daftar pengeluaran.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        // Implementasi pencarian (optional)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('expense_name', 'like', "%{$search}%")
                ->orWhere('payment_category', 'like', "%{$search}%")
                ->orWhere('payment_type', 'like', "%{$search}%")
                ->orWhere('invoice_number', 'like', "%{$search}%");
        }

        $getData = $query->orderBy('payment_date', 'desc')->paginate(10);

        // Data untuk Charts dan Revenue (sesuaikan dengan kebutuhan Anda)
        $barChartData = [
            'categories' => Expense::select('payment_category')
                ->distinct()
                ->pluck('payment_category')
                ->toArray(),
            'totals' => Expense::select('payment_category')
                ->groupBy('payment_category')
                ->selectRaw('payment_category, SUM(total) as total_sum')
                ->pluck('total_sum')
                ->toArray(),
        ];

        $pieChartData = [
            'labels' => Expense::select('payment_category')
                ->distinct()
                ->pluck('payment_category')
                ->toArray(),
            'data' => Expense::select('payment_category')
                ->groupBy('payment_category')
                ->selectRaw('payment_category, SUM(total) as total_sum')
                ->pluck('total_sum')
                ->toArray(),
            'backgroundColors' => [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40',
                // Tambahkan warna lain sesuai kebutuhan
            ],
        ];

        $weeklyRevenue = Expense::whereBetween('payment_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total');

        $monthlyRevenue = Expense::whereMonth('payment_date', now()->month)
            ->sum('total');

        $yearlyRevenue = Expense::whereYear('payment_date', now()->year)
            ->sum('total');

        return view('pengeluaran.index', compact('getData', 'barChartData', 'pieChartData', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue'));
    }

    /**
     * Menyimpan pengeluaran baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'expense_name' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
            'admin_fee' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'ppn_rate' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'ppn_amount' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'payment_type' => 'required|string|in:Cash,Transfer,Paper',
            'payment_category' => 'required|string',
            'invoice_number' => 'required|string|unique:expenses,invoice_number',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle file lampiran
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        // Simpan data pengeluaran
        Expense::create([
            'expense_name' => $request->expense_name,
            'payment_date' => $request->payment_date,
            'base_price' => $request->base_price,
            'admin_fee' => $request->admin_fee ?? 0,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'ppn_rate' => $request->ppn_rate,
            'ppn_amount' => $request->ppn_amount,
            'payment_type' => $request->payment_type,
            'payment_category' => $request->payment_category,
            'invoice_number' => $request->invoice_number,
            'remarks' => $request->remarks,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Expense successfully added.');
    }

    /**
     * Menampilkan form edit pengeluaran.
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        return view('pengeluaran.edit', compact('expense'));
    }

    /**
     * Memperbarui pengeluaran di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'expense_name' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'base_price' => 'required|numeric|min:0',
            'admin_fee' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'ppn_rate' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'ppn_amount' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'payment_type' => 'required|string|in:Cash,Transfer,Paper',
            'payment_category' => 'required|string',
            'invoice_number' => 'required|string',
            'remarks' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $expense = Expense::find($id);
        // Handle file lampiran
        if ($request->hasFile('attachment')) {
            // Hapus file lama jika ada
            if ($expense->attachment) {
                Storage::disk('public')->delete($expense->attachment);
            }
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $expense->attachment = $attachmentPath;
        }

        // Perbarui data pengeluaran
        $expense->update([
            'expense_name' => $request->expense_name,
            'payment_date' => $request->payment_date,
            'base_price' => $request->base_price,
            'admin_fee' => $request->admin_fee ?? 0,
            'quantity' => $request->quantity,
            'total' => $request->total,
            'ppn_rate' => $request->ppn_rate,
            'ppn_amount' => $request->ppn_amount,
            'payment_type' => $request->payment_type,
            'payment_category' => $request->payment_category,
            'invoice_number' => $request->invoice_number,
            'remarks' => $request->remarks,
            // 'attachment' sudah dihandle di atas
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Expense successfully updated.');
    }

    /**
     * Menghapus pengeluaran dari database.
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        // Hapus file lampiran jika ada
        if ($expense->attachment) {
            Storage::disk('public')->delete($expense->attachment);
        }

        $expense->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Expense successfully deleted.');
    }
}
