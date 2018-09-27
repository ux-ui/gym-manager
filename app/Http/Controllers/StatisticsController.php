<?php

namespace GymManager\Http\Controllers;

use GymManager\Charts\MemberRegistrationChart;
use GymManager\Models\Member;
use GymManager\Repositories\BranchRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StatisticsController extends Controller
{
    /**
     * Branch entity.
     *
     * @var \GymManager\Repositories\BranchRepository
     */
    protected $branch;

    /**
     * Create a new controller instance.
     *
     * @param  \GymManager\Repositories\BranchRepository  $branch
     * @return void
     */
    public function __construct(BranchRepository $branch)
    {
        $this->branch = $branch;

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
        $from = null;
        $to = null;
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
            $from = Carbon::createFromFormat('Y-m-d', $request->get('from'));
            $to = Carbon::createFromFormat('Y-m-d', $request->get('to'));
        } catch (InvalidArgumentException $exception) {
            $from = Carbon::today()->setTimeFromTimeString('00:00:00');
            $to = Carbon::today()->setTimeFromTimeString('23:59:59');
        }

        $year = 2018;

        $memberRegistrationChart = new MemberRegistrationChart();
        $memberRegistrationChart->title('월별 회원등록 지표');
        $memberRegistrationChart->labels(['1월', '2월', '3월', '5월', '6월', '7월', '8월', '9월', '9월', '10월', '11월', '12월']);

        foreach ($this->branch->all() as $branch) {
            $month = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            Member::where('branch_id', $branch->id)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('MONTH(`created_at`) as `month`')])
                ->each(function ($data) use (&$month) {
                    $month[$data->month - 1] = $data->count;
                });

            $colour = '#' . random_color();
            $memberRegistrationChart->dataset($branch->name, 'line', $month)
                ->color($colour)->backgroundColor($colour)->fill(false);
        }


        return view('statistics.index', compact('branch', 'from', 'to', 'memberRegistrationChart'));
    }
}
