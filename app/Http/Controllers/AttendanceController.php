<?php

namespace GymManager\Http\Controllers;

use GymManager\Models\Branch;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the all members of the specified branch for checking attendance.
     *
     * @param  \GymManager\Models\Branch|null  $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch = null)
    {
        if (! $branch) {
            $branch = Auth::user()->branches->first();
        }

        return view('attendance.index', compact('branch'));
    }
}
