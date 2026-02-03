@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard Super Admin</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('superadmin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <!-- Welcome Banner -->
    <div class="card bg-primary-600 text-white mb-24">
        <div class="card-body p-24">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h4 class="mb-4 text-white">Selamat Datang, {{ Auth::user()->name }}! 👋</h4>
                    <p class="mb-0 text-white-50">Kelola koperasi dengan lebih mudah dan efisien hari ini.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <!-- Stats Cards -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card p-0 shadow-none radius-12 border bg-gradient-start-1 h-100">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-64-px h-64-px bg-primary-600 rounded-circle d-flex justify-content-center align-items-center text-white text-2xl flex-shrink-0">
                            <iconify-icon icon="flowbite:users-group-solid"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-1 fw-medium text-secondary-light">Total Pengguna</span>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="card p-0 shadow-none radius-12 border bg-gradient-start-2 h-100">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-64-px h-64-px bg-success-main rounded-circle d-flex justify-content-center align-items-center text-white text-2xl flex-shrink-0">
                            <iconify-icon icon="mdi:account-group"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-1 fw-medium text-secondary-light">Total Anggota</span>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalAnggota) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="card p-0 shadow-none radius-12 border bg-gradient-start-3 h-100">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-64-px h-64-px bg-info-main rounded-circle d-flex justify-content-center align-items-center text-white text-2xl flex-shrink-0">
                            <iconify-icon icon="mdi:account-check"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-1 fw-medium text-secondary-light">Anggota Aktif</span>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalAnggotaAktif) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="card p-0 shadow-none radius-12 border bg-gradient-start-4 h-100">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center gap-3">
                        <span class="w-64-px h-64-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center text-white text-2xl flex-shrink-0">
                            <iconify-icon icon="mdi:file-clock"></iconify-icon>
                        </span>
                        <div>
                            <span class="mb-1 fw-medium text-secondary-light">Pengajuan Pending</span>
                            <h4 class="mb-0 fw-bold">{{ number_format($totalPengajuanPending) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-xxl-8 col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom">
                    <h6 class="card-title mb-0">Statistik Pendaftaran Anggota</h6>
                </div>
                <div class="card-body">
                    <div id="memberGrowthChart"></div>
                </div>
            </div>
        </div>

         <!-- Quick Stuff -->
         <div class="col-xxl-4 col-lg-4">
             <div class="card h-100">
                 <div class="card-header border-bottom">
                     <h6 class="card-title mb-0">Akses Cepat</h6>
                 </div>
                 <div class="card-body d-flex flex-column gap-3">
                        <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary-600 py-16 d-flex align-items-center justify-content-center gap-2">
                            <iconify-icon icon="mdi:account-plus" class="icon text-xl"></iconify-icon>
                            Tambah Pengguna Baru
                        </a>
                        <a href="{{ route('superadmin.anggota.create') }}" class="btn btn-success-600 py-16 d-flex align-items-center justify-content-center gap-2">
                            <iconify-icon icon="mdi:account-group-outline" class="icon text-xl"></iconify-icon>
                            Tambah Anggota Baru
                        </a>
                        <a href="{{ route('superadmin.anggota.index') }}" class="btn btn-info-600 py-16 d-flex align-items-center justify-content-center gap-2">
                            <iconify-icon icon="mdi:format-list-bulleted" class="icon text-xl"></iconify-icon>
                            Lihat Semua Data
                        </a>
                 </div>
             </div>
         </div>

        <!-- Latest Members -->
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">5 Anggota Terbaru</h6>
                    <a href="{{ route('superadmin.anggota.index') }}" class="text-primary-600 fw-medium text-sm">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Tanggal Daftar</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestAnggota as $anggota)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/user-list/user-list1.png') }}" alt="" class="flex-shrink-0 me-12 radius-8" style="width: 40px; height: 40px;">
                                            <div>
                                                <h6 class="text-md mb-0 fw-medium">{{ $anggota->user->name }}</h6>
                                                <span class="text-sm text-secondary-light">{{ $anggota->nomor_anggota }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $anggota->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="{{ $anggota->status_keanggotaan == 'Aktif' ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }} px-24 py-4 rounded-pill fw-medium text-sm">
                                            {{ $anggota->status_keanggotaan }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('superadmin.anggota.show', $anggota) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mdi:eye"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center p-3">Belum ada anggota baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Member Growth Chart
    var options = {
        series: [{
            name: 'Pendaftaran Anggota',
            data: @json($monthlyStats->values())
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            categories: @json($monthlyStats->keys()),
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            show: false
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        colors: ['#487fff'],
        grid: {
            show: false,
        }
    };

    var chart = new ApexCharts(document.querySelector("#memberGrowthChart"), options);
    chart.render();
</script>
@endpush
