@extends('business.layouts.app')

@section('title')
    Business Home
@endsection

@section('content')
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                <div class="col-12">
                    <div class="row row-cards">
                        <div class="col-sm-6 col-lg-3">
                            <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                                <div class="input-icon">
                                    <a target="_blank" href="#">
                                        <button type="button" class="btn btn-info">
                                            See All Driver Locations
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th class="w-1">
                                        id
                                    </th>
                                    <th>Driver name</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Registration date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($drivers as $driver)
                                    <tr>
                                        <td><span class="text-muted">{{ $driver->id }}</span></td>
                                        <td>
                                            {{ $driver->full_name }}
                                        </td>
                                        <td>
                                            {{ $driver->phone }}
                                        </td>
                                        <td>
                                            {{ $driver->country->name }}
                                        </td>
                                        <td>
                                            {{ $driver->city->name }}
                                        </td>
                                        <td>
                                            {{ $driver->address }}
                                        </td>
                                        <td>
                                            @if($driver->status == App\Enums\DriverStatus::PENDING)
                                                <span class="badge bg-info me-1"></span> Pending
                                            @elseif($driver->status == App\Enums\DriverStatus::APPROVED)
                                                <span class="badge bg-success me-1"></span> Active
                                            @elseif($driver->status == App\Enums\DriverStatus::REJECTED)
                                                <span class="badge bg-danger me-1"></span> Rejected
                                            @else
                                                <span class="badge bg-danger me-1"></span> Unknown
                                            @endif
                                        </td>
                                        <td>
                                            {{ date_format($driver->created_at, 'M/d/Y') }}
                                        </td>
                                        <td class="text-end">
                                            <a target="_blank" href="https://www.google.com/maps/place/{{ $driver->latitude }},{{ $driver->longitude }}" class="btn btn-danger" role="button" aria-pressed="true">
                                                Open Map
                                            </a>
                                            <a href="{{ route('business.driver', ['id' => $driver->id ]) }}" class="btn btn-success" role="button" aria-pressed="true">
                                                View driver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger" role="alert">
                                        No Data !
                                    </div>
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
