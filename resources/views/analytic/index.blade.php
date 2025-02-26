@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-6 col-12 d-flex ms-auto">
                <a href="javascript:;" class="btn btn-icon btn-outline-white ms-auto">
                    <span class="btn-inner--text">Export</span>
                    <span class="btn-inner--icon ms-2"><i class="ni ni-folder-17"></i></span>
                </a>
                <div class="dropleft ms-3">
                    <button class="btn bg-gradient-dark dropdown-toggle" type="button" id="dropdownImport"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Today
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownImport">
                        <li><a class="dropdown-item" href="javascript:;">Yesterday</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Last 7 days</a></li>
                        <li><a class="dropdown-item" href="javascript:;">Last 30 days</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        930
                                        <span class="text-success text-sm font-weight-bolder">+55%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                                    <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">New Users</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        744
                                        <span class="text-success text-sm font-weight-bolder">+3%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sessions</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        1,414
                                        <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                                    <i class="ni ni-watch-time text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Pages/Session</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        1.76
                                        <span class="text-success text-sm font-weight-bolder">+5%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                                    <i class="ni ni-image text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Traffic channels</h6>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-primary"></i>
                                <span class="text-dark text-xs">Organic search</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-dark"></i>
                                <span class="text-dark text-xs">Referral</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-info"></i>
                                <span class="text-dark text-xs">Social media</span>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="375"
                                style="display: block; box-sizing: border-box; height: 300px; width: 778px;"
                                width="973"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 mt-4 mt-lg-0">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Referrals</h6>
                            <button type="button"
                                class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                aria-label="See which websites are sending traffic to your website"
                                data-bs-original-title="See which websites are sending traffic to your website">
                                <i class="fas fa-info"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-5 col-12 text-center">
                                <div class="chart mt-5">
                                    <canvas id="chart-doughnut" class="chart-canvas" height="250"
                                        style="display: block; box-sizing: border-box; height: 200px; width: 778px;"
                                        width="973"></canvas>
                                </div>
                                <a class="btn btn-sm bg-gradient-secondary mt-4">See all referrals</a>
                            </div>
                            <div class="col-lg-7 col-12">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="../../assets/img/small-logos/logo-xd.svg"
                                                                class="avatar avatar-sm me-2" alt="logo_xd">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Adobe</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold"> 25% </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="../../assets/img/small-logos/logo-atlassian.svg"
                                                                class="avatar avatar-sm me-2" alt="logo_atlassian">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Atlassian</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold"> 3% </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="../../assets/img/small-logos/logo-slack.svg"
                                                                class="avatar avatar-sm me-2" alt="logo_slack">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Slack</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold"> 12% </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="../../assets/img/small-logos/logo-spotify.svg"
                                                                class="avatar avatar-sm me-2" alt="logo_spotify">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Spotify</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold"> 7% </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="../../assets/img/small-logos/logo-jira.svg"
                                                                class="avatar avatar-sm me-2" alt="logo_jira">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jira</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold"> 10% </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Social</h6>
                            <button type="button"
                                class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                aria-label="See how much traffic do you get from social media"
                                data-bs-original-title="See how much traffic do you get from social media">
                                <i class="fas fa-info"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <a class="btn btn-facebook btn-simple mb-0 p-0" href="javascript:;">
                                            <i class="fab fa-facebook fa-lg"></i>
                                        </a>
                                        <span class="me-2 text-sm font-weight-bold text-capitalize ms-2">Facebook</span>
                                        <span class="ms-auto text-sm font-weight-bold">80%</span>
                                    </div>
                                    <div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-gradient-dark w-80" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <a class="btn btn-twitter btn-simple mb-0 p-0" href="javascript:;">
                                            <i class="fab fa-twitter fa-lg"></i>
                                        </a>
                                        <span class="me-2 text-sm font-weight-bold text-capitalize ms-2">Twitter</span>
                                        <span class="ms-auto text-sm font-weight-bold">40%</span>
                                    </div>
                                    <div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-gradient-dark w-40" role="progressbar"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <a class="btn btn-reddit btn-simple mb-0 p-0" href="javascript:;">
                                            <i class="fab fa-reddit fa-lg"></i>
                                        </a>
                                        <span class="me-2 text-sm font-weight-bold text-capitalize ms-2">Reddit</span>
                                        <span class="ms-auto text-sm font-weight-bold">30%</span>
                                    </div>
                                    <div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-gradient-dark w-30" role="progressbar"
                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <a class="btn btn-youtube btn-simple mb-0 p-0" href="javascript:;">
                                            <i class="fab fa-youtube fa-lg"></i>
                                        </a>
                                        <span class="me-2 text-sm font-weight-bold text-capitalize ms-2">Youtube</span>
                                        <span class="ms-auto text-sm font-weight-bold">25%</span>
                                    </div>
                                    <div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-gradient-dark w-25" role="progressbar"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <a class="btn btn-slack btn-simple mb-0 p-0" href="javascript:;">
                                            <i class="fab fa-slack fa-lg"></i>
                                        </a>
                                        <span class="me-2 text-sm font-weight-bold text-capitalize ms-2">Slack</span>
                                        <span class="ms-auto text-sm font-weight-bold">15%</span>
                                    </div>
                                    <div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-gradient-dark w-15" role="progressbar"
                                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card h-100 mt-4 mt-md-0">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex align-items-center">
                            <h6>Pages</h6>
                            <button type="button"
                                class="btn btn-icon-only btn-rounded btn-outline-success mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                aria-label="Data is based from sessions and is 100% accurate"
                                data-bs-original-title="Data is based from sessions and is 100% accurate">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-3 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Page</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Page Views</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Avg. Time</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Bounce Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">1. /bits</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">345</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:17:07</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">40.91%</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">2. /pages/argon-dashboard</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">520</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:23:13</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">30.14%</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">3. /pages/soft-ui-dashboard</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">122</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:3:10</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">54.10%</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">4. /bootstrap-themes</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">1,900</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:30:42</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">20.93%</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">5. /react-themes</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">1,442</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:31:50</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">34.98%</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">6. /product/argon-dashboard-angular
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">201</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:12:42</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">21.4%</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">7. /product/material-dashboard-pro</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">2,115</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">00:50:11</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">34.98%</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>2024,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                    target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                    target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                    target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection


@push('top')
@endpush

@push('scripts')
@endpush
