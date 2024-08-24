@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Revenue for This Year</h5>
                        </div>
                    </div>
                    <div id="revenue"></div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var revenueData = @json($revenueData);
                            var categories = [
                                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];

                            var chartOptions = {
                                series: [{
                                    name: "{{ $currentYear }}",
                                    data: categories.map(function(month, index) {
                                        return revenueData[index + 1] ||
                                            0; // +1 karena index bulan mulai dari 1
                                    }),
                                }],
                                chart: {
                                    toolbar: {
                                        show: false
                                    },
                                    type: "line", // Ganti tipe chart menjadi garis
                                    height: 270
                                },
                                colors: ["var(--bs-primary)"],
                                stroke: {
                                    width: 2, // Lebar garis
                                    curve: 'smooth' // Untuk membuat garis lebih halus
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                legend: {
                                    show: false
                                },
                                grid: {
                                    show: true,
                                    padding: {
                                        top: 0,
                                        bottom: 0
                                    },
                                    borderColor: "rgba(0,0,0,0.05)",
                                },
                                xaxis: {
                                    categories: categories,
                                    axisBorder: {
                                        show: false
                                    },
                                    axisTicks: {
                                        show: false
                                    },
                                    labels: {
                                        style: {
                                            fontSize: "13px",
                                            colors: "#adb0bb",
                                            fontWeight: "400"
                                        },
                                    },
                                },
                                yaxis: {
                                    labels: {
                                        formatter: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID'); // Format angka dalam rupiah
                                        }
                                    }
                                },
                                tooltip: {
                                    theme: "dark",
                                    y: {
                                        formatter: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID'); // Format angka dalam rupiah
                                        }
                                    }
                                },
                            };

                            new ApexCharts(document.querySelector("#revenue"), chartOptions).render();
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-6 mb-4 pb-3">
                                <span
                                    class="round-48 d-flex align-items-center justify-content-center rounded bg-secondary-subtle">
                                    <iconify-icon icon="solar:football-outline" class="fs-6 text-secondary"></iconify-icon>
                                </span>
                                <h6 class="mb-0 fs-4">Target Revenue</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-6">
                                <h6 class="mb-0 fw-medium">Rp. {{ number_format($targetMonthlyIncome) }}</h6>
                                <h6 class="mb-0 fw-medium">{{ number_format($percentageAchieved, 0) }}%</h6>
                            </div>
                            <div class="progress" role="progressbar" aria-label="Basic example"
                                aria-valuenow="{{ $percentageAchieved }}" aria-valuemin="0" aria-valuemax="100"
                                style="height: 7px;">
                                <div class="progress-bar bg-secondary" style="width: {{ $percentageAchieved }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-6 mb-4">
                                <span
                                    class="round-48 d-flex align-items-center justify-content-center rounded bg-primary-subtle">
                                    <iconify-icon icon="fa6-solid:rupiah-sign" class="text-dark"
                                        style="font-weight: 900"></iconify-icon>
                                </span>
                                <h6 class="mb-0 fs-4">Total Income Today</h6>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="text-title" style="font-weight: 700">
                                        Rp. {{ number_format($totalIncomeToday) }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Revenue by Product</h5>
                    <div class="table-responsive" data-simplebar>
                        <table class="table text-nowrap align-middle table-custom mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-dark fw-normal ps-0">Product
                                    </th>
                                    <th scope="col" class="text-dark fw-normal">Priority</th>
                                    <th scope="col" class="text-dark fw-normal">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productRevenue as $item)
                                    <tr>
                                        <td class="ps-0">
                                            <div class="d-flex align-items-center gap-6">
                                                <img src="{{ $item->image_thumbnail ? asset('storage/' . $item->image_thumbnail) : asset('assets/image/empty-image.webp') }}"
                                                    alt="prd1" width="48" class="rounded" />
                                                <div>
                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                    <span>Rp. {{ number_format($item->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge text-dark px-3 {{ $item->priority === 'High' ? 'bg-success-subtle text-danger' : ($item->priority === 'Medium' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-success') }}">
                                                {{ $item->priority }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-dark">Rp.
                                                {{ number_format($item->revenue, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-lg-4">
            <div class="card overflow-hidden hover-img">
                <div class="position-relative">
                    <a href="javascript:void(0)">
                        <img src="../assets/images/blog/blog-img1.jpg" class="card-img-top" alt="matdash-img">
                    </a>
                    <span
                        class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                        min Read</span>
                    <img src="../assets/images/profile/user-3.jpg" alt="matdash-img"
                        class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40"
                        height="40" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Georgeanna Ramero">
                </div>
                <div class="card-body p-4">
                    <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Social</span>
                    <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">As
                        yen tumbles, gadget-loving
                        Japan goes
                        for secondhand iPhones</a>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-eye text-dark fs-5"></i>9,125
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-message-2 text-dark fs-5"></i>3
                        </div>
                        <div class="d-flex align-items-center fs-2 ms-auto">
                            <i class="ti ti-point text-dark"></i>Mon, Dec 19
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card overflow-hidden hover-img">
                <div class="position-relative">
                    <a href="javascript:void(0)">
                        <img src="../assets/images/blog/blog-img2.jpg" class="card-img-top" alt="matdash-img">
                    </a>
                    <span
                        class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                        min Read</span>
                    <img src="../assets/images/profile/user-2.jpg" alt="matdash-img"
                        class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40"
                        height="40" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Georgeanna Ramero">
                </div>
                <div class="card-body p-4">
                    <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Gadget</span>
                    <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">Intel loses bid to
                        revive
                        antitrust case
                        against patent foe Fortress</a>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-eye text-dark fs-5"></i>4,150
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-message-2 text-dark fs-5"></i>38
                        </div>
                        <div class="d-flex align-items-center fs-2 ms-auto">
                            <i class="ti ti-point text-dark"></i>Sun, Dec 18
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card overflow-hidden hover-img">
                <div class="position-relative">
                    <a href="javascript:void(0)">
                        <img src="../assets/images/blog/blog-img3.jpg" class="card-img-top" alt="matdash-img">
                    </a>
                    <span
                        class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                        min Read</span>
                    <img src="../assets/images/profile/user-3.jpg" alt="matdash-img"
                        class="img-fluid rounded-circle position-absolute bottom-0 start-0 mb-n9 ms-9" width="40"
                        height="40" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Georgeanna Ramero">
                </div>
                <div class="card-body p-4">
                    <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">Health</span>
                    <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="">COVID outbreak deepens
                        as more
                        lockdowns
                        loom in China</a>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-eye text-dark fs-5"></i>9,480
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-message-2 text-dark fs-5"></i>12
                        </div>
                        <div class="d-flex align-items-center fs-2 ms-auto">
                            <i class="ti ti-point text-dark"></i>Sat, Dec 17
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
