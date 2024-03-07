<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return \view('Home.index');
    }

    public function contact(): View
    {
        return \view('Home.contact');
    }

    public function rules(): View
    {
        return \view('Home.rules');
    }

    public function deletePolicy(): View
    {
        return \view('Home.deletePolicy');
    }
}
