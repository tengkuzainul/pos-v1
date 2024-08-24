@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between mb-3">
            <h1 class="fw-bold display-6 text-primary">Income Report</h1>
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Income Report</li>
                </ol>
            </nav>
        </div>

        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body">
                    <form action="{{ route('report.index') }}" method="GET">
                        <div class="d-flex justify-content-between align-items-top">
                            <p class="h3 card-title text-dark mb-3">Form Income Report</p>
                            <div class="d-flex gap-3 align-items-center">
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="ti ti-circle-check me-2"></i>Search Data
                                </button>
                                <button type="button" onclick="window.location.href='{{ route('report.index') }}'"
                                    class="btn btn-danger px-3">
                                    <i class="ti ti-circle-x me-2"></i>Clear Filter
                                </button>
                            </div>
                        </div>

                        <div class="row align-items-center mt-2">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="text" class="form-control datepicker" id="startDate" name="start_date"
                                        value="{{ request('start_date') }}" placeholder="Input Start Date" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="text" class="form-control datepicker" id="endDate" name="end_date"
                                        value="{{ request('end_date') }}" placeholder="Input End Date" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="filterBy" class="form-label">Filter By</label>
                                    <select name="filter_by" id="filterBy" class="form-control form-control-sm text-dark"
                                        style="font-weight: 700">
                                        <option selected disabled>--- Select Filter ---</option>
                                        <option value="day" {{ request('filter_by') == 'day' ? 'selected' : '' }}>Day
                                        </option>
                                        <option value="month" {{ request('filter_by') == 'month' ? 'selected' : '' }}>Month
                                        </option>
                                        <option value="year" {{ request('filter_by') == 'year' ? 'selected' : '' }}>Year
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 align-items-start">
                            <p class="h3 card-title text-dark">Incomes/Day</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered border-dark table-sm table-striped table-hover mt-3">
                                <thead>
                                    <tr>
                                        <th class="text-dark" style="width: 60px">No</th>
                                        <th class="text-dark">Date</th>
                                        <th class="text-dark">Income (Rp)</th>
                                        <th class="text-dark" style="width: 150px">Total Transaction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($day as $income)
                                        <tr>
                                            <td class="text-dark text-center">{{ $loop->iteration }}</td>
                                            <td class="text-dark">{{ date('d/F/Y', strtotime($income->date)) }}</td>
                                            <td class="text-dark">Rp. {{ number_format($income->income) }}</td>
                                            <td class="text-dark">{{ $income->total_transaction }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-dark">Data not found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-dark" style="width: 60px">No</th>
                                        <th class="text-dark">Date</th>
                                        <th class="text-dark">Income (Rp)</th>
                                        <th class="text-dark">Total Transaction</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('date-picker')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi datepicker untuk setiap elemen dengan kelas .datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom auto', // Datepicker muncul di bawah
                templates: {
                    leftArrow: '&laquo;',
                    rightArrow: '&raquo;'
                }
            });
        });
    </script>
@endpush
