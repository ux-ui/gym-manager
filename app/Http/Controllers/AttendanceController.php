<?php

namespace GymManager\Http\Controllers;

use GymManager\Models\Member;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = null;

        try {
            if (! $request->has('branch')) {
                $branch = Auth::user()->branches()->firstOrFail();
            } else {
                $branch = Auth::user()->branches()->where('id', $request->get('branch'))->firstOrFail();
            }
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }

        try {
            $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        } catch (InvalidArgumentException $exception) {
            $date = Carbon::today();
        }

        $members = $branch->members()->with(['attendances' => function ($query) use ($date) {
            $query->where('date', $date->format('Y-m-d'));
        }])->orderBy('name', 'ASC')->get();

        return view('attendance.index', compact('branch', 'date', 'members'));
    }

    /**
     * Handle the member attendance request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $flag = null;

        $date = $request->get('date');
        $member = Member::find($request->get('member'));

        $attendance = $member->attendances()->where('date', $date)->first();

        if ($attendance) {
            $attendance->delete();
            $flag = false;
        } else {
            $member->attendances()->create(['date' => $date]);
            $flag = true;
        }

        return response()->json(['success' => true, 'flag' => $flag]);
    }
}
