@extends('layouts.app')

@push('chart')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container">
    <div class="row pt-4">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h4 class="card-title text-primary">Selamat Datang, <b>{{ auth()->user()->name }}!</b></h4>
                            <p class="mb-4">
                                {{-- {{ $dateNow }} --}}
                            </p>
                            <p style="font-size: smaller" class="text-gray">&nbsp;</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="https://telegra.ph/file/f46a1179ee7e3715d2339.png" height="140"
                                 alt="View Badge User">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3"
                             style="position: relative;">
                            <div class="">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2"></h5>
                                    <span class="badge bg-label-warning rounded-pill"></span>
                                </div>
                                
                            </div>
                            <div>
                                <canvas id="reportChart"></canvas>
                            </div>
                            {{-- <div id="profileReportChart" style="min-height: 80px; width: 80%">
                                
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <x-dashboard-card-simple
                        :label="__('All Documents')"
                        :value="$totalArchives"
                        :daily="true"
                        color="primary"
                        icon="bx-folder"
                        :percentage="$percentageChange"
                    />
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <x-dashboard-card-simple
                        :label="__('Total Users')"
                        :value="$totalUsers"
                        :daily="true"
                        color="success"
                        icon="bxs-user-account"
                        :percentage="0"
                    />
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <x-dashboard-card-simple
                        :label="__('User Active')"
                        :value="$totalUsersActive"
                        :daily="true"
                        color="warning"
                        icon="bx-user-check"
                        :percentage="0"
                    />
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <x-dashboard-card-simple
                        :label="__('Category')"
                        :value="$totalCategory"
                        :daily="false"
                        color="info"
                        icon="bx-category"
                        :percentage="0"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sweetalert2')
{{-- <script>
    var ctx = document.getElementById('reportChart').getContext('2d');
    var chartData = @json($chartData);

    var reportChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Laporan Masuk',
                data: chartData.data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> --}}
@endsection
