<?php

namespace App\Http\Controllers;

class FibreTraceDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('admin.DashboardPage');
    }
}
