<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Media;
use App\Models\Order;
use App\Models\DriverRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BusinessController extends Controller
{
    public function dashboard(): View
    {
        $drivers = Driver::where('business_code', Auth::guard('business')->user()->business_code)->paginate(10);

        return \view('business.dashboard', compact('drivers'));
    }

    public function settings(): View
    {
        return \view('business.settings');
    }

    public function driver($id): View
    {
        $driver = Driver::findOrFail($id);

        $driverOrders = Order::where('driver_id', $id)->paginate(20);

        $driverRoutes = DriverRoute::where('driver_id', $id)->paginate(30);

        return \view('business.driver', compact('driver', 'driverOrders', 'driverRoutes'));
    }

    public function driverEdit(): View
    {
        return \view('business.driverEdit');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return to_route('business.login');
    }
}
