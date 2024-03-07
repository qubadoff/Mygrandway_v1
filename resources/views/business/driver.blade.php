@extends('business.layouts.app')

@section('title')
    Driver info
@endsection

@section('content')

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-home-3" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l-2 0l9 -9l9 9l-2 0"></path><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>
                                        Driver information</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-3" role="tabpanel">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b> Name </b> : {{ $driver->full_name }} <br/><br/>
                                                <b> Phone </b>: {{ $driver->phone }}<br/><br/>
                                                <b> Country </b>: {{ $driver->country->name }}<br/><br/>
                                                <b> City </b>: {{ $driver->city->name }}<br/><br/>
                                            </div>
                                            <div class="col-md-6">
                                                <b> Address </b>: {{ $driver->address }}<br/><br/>
                                                <b> About Driver </b>: {{ $driver->about }}<br/><br/>
                                                <b> License NO </b>: {{ $driver->driver_license_no }}<br/><br/>
                                                <b> Truck type </b>: {{ $driver->truck_type->name }}<br/><br/>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a target="_blank" href="https://www.google.com/maps/place/{{ $driver->latitude }},{{ $driver->longitude }}" class="btn btn-primary w-100">
                                                    Driver Location
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Driver Orders</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th class="w-1">
                                        id
                                    </th>
                                    <th>Order status</th>
                                    <th>Customer</th>
                                    <th>From City Name</th>
                                    <th>To City Name</th>
                                    <th>Truck Type</th>
                                    <th>Pickup date</th>
                                    <th>Time to unload</th>
                                    <th>Cargo information</th>
                                    <th>Price</th>
                                    <th>Currency</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($driverOrders as $order)
                                    <tr>
                                        <td>
                                            {{ $order->id }}
                                        </td>
                                        <td>
                                            @if($order->status == App\Enums\OrderStatus::Pending)
                                                <span class="badge bg-info me-1"></span> Pending
                                            @elseif($order->status == App\Enums\OrderStatus::Chatting)
                                                <span class="badge bg-success me-1"></span> Chatting
                                            @elseif($order->status == App\Enums\OrderStatus::Accepted)
                                                <span class="badge bg-success me-1"></span> Accepted
                                            @elseif($order->status == App\Enums\OrderStatus::Rejected)
                                                <span class="badge bg-danger me-1"></span> Rejected
                                            @elseif($order->status == App\Enums\OrderStatus::InProgress)
                                                <span class="badge bg-info me-1"></span> InProgress
                                            @elseif($order->status == App\Enums\OrderStatus::Completed)
                                                <span class="badge bg-success me-1"></span> Completed
                                            @elseif($order->status == App\Enums\OrderStatus::Canceled)
                                                <span class="badge bg-danger me-1"></span> Canceled
                                            @else
                                                <span class="badge bg-danger me-1"></span> Unknown
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->customer->full_name }}
                                        </td>
                                        <td>
                                            {{ $order->from_city->name }}
                                        </td>
                                        <td>
                                            {{ $order->to_city->name }}
                                        </td>
                                        <td>
                                            {{ $order->truckType->name }}
                                        </td>
                                        <td>
                                            {{ date_format($order->pickup_at, 'M/d/Y') }}
                                        </td>
                                        <td>
                                            {{ $order->dropoff_at }} day
                                        </td>
                                        <td>
                                            {{ $order->comment }}
                                        </td>
                                        <td>
                                            {{ $order->price }}
                                        </td>
                                        <td>
                                            {{ $order->currency->name }}
                                        </td>
                                        <td>
                                            {{ date_format($order->created_at, 'M/d/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    No Data
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Driver Routes</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                    <tr>
                                        <th class="w-1">
                                            id
                                        </th>
                                        <th>From city name</th>
                                        <th>To city name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($driverRoutes as $route)
                                        <tr>
                                            <td>
                                                {{ $route->id }}
                                            </td>
                                            <td>
                                                {{ $route->from_city->name }}
                                            </td>
                                            <td>
                                                {{ $route->to_city->name }}
                                            </td>
                                        </tr>
                                    @empty
                                        No Data
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
