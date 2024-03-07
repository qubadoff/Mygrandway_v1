@extends('business.layouts.app')

@section('title')
    Settings Page
@endsection

@section('content')

    <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="col-md-12">
                    <form class="card">
                        <div class="card-header">
                            <h3 class="card-title">Business settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Business name</label>
                                <div>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="{{ \Illuminate\Support\Facades\Auth::guard('business')->user()->name }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Business code</label>
                                <div>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="{{ \Illuminate\Support\Facades\Auth::guard('business')->user()->business_code }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Business Location</label>
                                <div>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="{{ \Illuminate\Support\Facades\Auth::guard('business')->user()->location }}">
                                </div>
                            </div>

                            <div class="mb-3 mb-0">
                                <label class="form-label">Description</label>
                                <textarea rows="5" class="form-control" placeholder="Here can be your description" value="Mike"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Business email</label>
                                <div>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="{{ \Illuminate\Support\Facades\Auth::guard('business')->user()->email }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Business email</label>
                                <div>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="{{ \Illuminate\Support\Facades\Auth::guard('business')->user()->phone }}">
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label required">Password</label>
                                <div>
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
