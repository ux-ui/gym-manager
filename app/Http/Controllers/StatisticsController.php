<?php

namespace GymManager\Http\Controllers;

use GymManager\Charts\MemberRegistrationChart;
use GymManager\Models\Attendance;
use GymManager\Models\Ledger;
use GymManager\Models\Member;
use GymManager\Repositories\BranchRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
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
        return view('statistics.index');
    }

    /**
     * Show the detail statistics charts by condition.
     *
     * @param  string  $type
     * @param  string  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(string $type, string $condition)
    {
        $branches = collect([]);
        $conditions = request()->all();

        foreach (request()->get('branches', Auth::user()->branchesToPluckedArray('id')) as $id) {
            $branches->push(Auth::user()->branches()->where('id', $id)->firstOrFail());
        }

        $methodName = sprintf("_%s%s", ucfirst(camel_case($type)), ucfirst(camel_case($condition)));
        $func = call_user_func_array([$this, $methodName], [$branches, $conditions]);

        return $func;
    }

    /**
     * Show the yearly member registration statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _MemberRegistrationYearly(Collection $branches, array $conditions)
    {
        $years = Member::groupBy(DB::raw('YEAR(created_at)'))
            ->get([DB::raw('YEAR(`created_at`) as `year`')])->toArray();

        $chart = new MemberRegistrationChart();
        $chart->title('연도별 회원등록 지표');
        $chart->labels(array_map(function ($value) {
            return sprintf("%d년", $value);
        }, array_pluck($years, 'year')));

        foreach ($branches as $branch) {
            $collection = array_fill_keys(array_pluck($years, 'year'), 0);

            Member::where('branch_id', $branch->id)
                ->groupBy(DB::raw('YEAR(`created_at`)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('YEAR(`created_at`) as `year`')])
                ->each(function ($data) use (&$collection) {
                    $collection[$data->year] = $data->count;
                });

            $chart->dataset($branch->name, 'line', array_values($collection));
        }

        return view('statistics.member_registration.yearly', compact('branches', 'chart'));
    }

    /**
     * Show the monthly member registration statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _MemberRegistrationMonthly(Collection $branches, array $conditions)
    {
        $year = $conditions['year'] ?? date("Y");

        $chart = new MemberRegistrationChart();
        $chart->title("{$year}년도 월별 회원등록 지표");
        $chart->labels(['1월', '2월', '3월', '5월', '6월', '7월', '8월', '9월', '9월', '10월', '11월', '12월']);

        foreach ($branches as $branch) {
            $month = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            Member::where('branch_id', $branch->id)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('MONTH(`created_at`) as `month`')])
                ->each(function ($data) use (&$month) {
                    $month[$data->month - 1] = sprintf("%d", $data->count);
                });

            $chart->dataset($branch->name, 'line', $month);
        }

        return view('statistics.member_registration.monthly', compact('year', 'branches', 'chart'));
    }

    /**
     * Show the daily member registration statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _MemberRegistrationDaily(Collection $branches, array $conditions)
    {
        $year = $conditions['year'] ?? date("Y");
        $month = $conditions['month'] ?? date("m");
        $last_day = date("t", strtotime(sprintf("%s-%s-01", $year, $month)));

        $days = [];
        for ($i = 0; $i < $last_day; $i++) $days[] = sprintf("%d일", $i + 1);

        $chart = new MemberRegistrationChart();
        $chart->title("{$year}년 {$month}월 일별 회원등록 지표");
        $chart->labels($days);

        foreach ($branches as $branch) {
            $collection = array_fill(0, sizeof($days), 0);

            Member::where('branch_id', $branch->id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy(DB::raw('DAY(`created_at`)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('DAY(`created_at`) as `day`')])
                ->each(function ($data) use (&$collection) {
                    $collection[$data->day - 1] = $data->count;
                });

            $chart->dataset($branch->name, 'line', array_values($collection));
        }

        return view('statistics.member_registration.daily', compact('year', 'month', 'branches', 'chart'));
    }

    /**
     * Show the yearly member attendance statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _MemberAttendanceYearly(Collection $branches, array $conditions)
    {
        $years = Attendance::groupBy(DB::raw('YEAR(`date`)'))
            ->get([DB::raw('YEAR(`date`) as `year`')])->toArray();

        $chart = new MemberRegistrationChart();
        $chart->title('연도별 회원 출석률 지표');
        $chart->labels(array_map(function ($value) {
            return sprintf("%d년", $value);
        }, array_pluck($years, 'year')));

        foreach ($branches as $branch) {
            $memberCount = $branch->members()->count();
            $collection = array_fill_keys(array_pluck($years, 'year'), 0);

            Attendance::whereHas('member.branch', function ($query) use ($branch) {
                $query->where('id', $branch->id);
            })->groupBy(DB::raw('YEAR(`date`)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('YEAR(`date`) as `year`')])
                ->each(function ($data) use (&$collection, $memberCount) {
                    $collection[$data->year] = round($data->count / $memberCount * 100, 1);
                });

            $chart->dataset($branch->name, 'line', array_values($collection));
        }

        return view('statistics.member_attendance.yearly', compact('branches', 'chart'));
    }

    /**
     * Show the monthly member attendance statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _MemberAttendanceMonthly(Collection $branches, array $conditions)
    {
        $year = $conditions['year'] ?? date("Y");

        $chart = new MemberRegistrationChart();
        $chart->title("{$year}년도 월별 회원 출석률 지표");
        $chart->labels(['1월', '2월', '3월', '5월', '6월', '7월', '8월', '9월', '9월', '10월', '11월', '12월']);

        foreach ($branches as $branch) {
            $memberCount = $branch->members()->count();
            $month = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            Attendance::whereHas('member.branch', function ($query) use ($branch) {
                $query->where('id', $branch->id);
            })->whereYear('date', $year)
                ->groupBy(DB::raw('YEAR(`date`)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('MONTH(`date`) as `month`')])
                ->each(function ($data) use (&$month, $memberCount) {
                    $month[$data->month - 1] = round($data->count / $memberCount * 100, 1);
                });

            $chart->dataset($branch->name, 'line', $month);
        }

        return view('statistics.member_attendance.monthly', compact('year', 'branches', 'chart'));
    }

    /**
     * Show the daily member attendance statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _MemberAttendanceDaily(Collection $branches, array $conditions)
    {
        $year = $conditions['year'] ?? date("Y");
        $month = $conditions['month'] ?? date("m");
        $last_day = date("t", strtotime(sprintf("%s-%s-01", $year, $month)));

        $days = [];
        for ($i = 0; $i < $last_day; $i++) $days[] = sprintf("%d일", $i + 1);

        $chart = new MemberRegistrationChart();
        $chart->title("{$year}년 {$month}월 일별 회원 출석률 지표");
        $chart->labels($days);

        foreach ($branches as $branch) {
            $memberCount = $branch->members()->count();
            $collection = array_fill(0, sizeof($days), 0);

            Attendance::whereHas('member.branch', function ($query) use ($branch) {
                $query->where('id', $branch->id);
            })->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->groupBy(DB::raw('DAY(`date`)'))
                ->get([DB::raw('COUNT(*) as `count`'), DB::raw('DAY(`date`) as `day`')])
                ->each(function ($data) use (&$collection, $memberCount) {
                    $collection[$data->day - 1] = round($data->count / $memberCount * 100, 1);
                });

            $chart->dataset($branch->name, 'line', array_values($collection));
        }

        return view('statistics.member_attendance.daily', compact('year', 'month', 'branches', 'chart'));
    }

    /**
     * Show the yearly ledger statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _LedgerYearly(Collection $branches, array $conditions)
    {
        $ledgers = Ledger::whereIn('branch_id', $branches->pluck('id'))
            ->groupBy(DB::raw('YEAR(`created_at`)'))
            ->groupBy(DB::raw('branch_id'))->get([
                DB::raw('SUM(IF(type=\'+\', `amount`, 0)) as `add`'),
                DB::raw('SUM(IF(type=\'-\', `amount`, 0)) as `sub`'),
                DB::raw('YEAR(`created_at`) as `year`'),
                DB::raw('`branch_id`'),
            ]);

        return view('statistics.ledger.yearly', compact('branches', 'ledgers'));
    }

    /**
     * Show the monthly ledger statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _LedgerMonthly(Collection $branches, array $conditions)
    {
        $year = $conditions['year'] ?? date("Y");

        $ledgers = Ledger::whereIn('branch_id', $branches->pluck('id'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(`created_at`)'))
            ->groupBy(DB::raw('branch_id'))->get([
                DB::raw('SUM(IF(type=\'+\', `amount`, 0)) as `add`'),
                DB::raw('SUM(IF(type=\'-\', `amount`, 0)) as `sub`'),
                DB::raw('YEAR(`created_at`) as `year`'),
                DB::raw('MONTH(`created_at`) as `month`'),
                DB::raw('`branch_id`'),
            ]);

        return view('statistics.ledger.monthly', compact('branches', 'ledgers', 'year'));
    }

    /**
     * Show the daily ledger statistics.
     *
     * @param  \Illuminate\Support\Collection  $branches
     * @param  array  $conditions
     * @return \Illuminate\Http\Response
     */
    private function _LedgerDaily(Collection $branches, array $conditions)
    {
        $year = $conditions['year'] ?? date("Y");
        $month = $conditions['month'] ?? date("m");

        $ledgers = Ledger::whereIn('branch_id', $branches->pluck('id'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy(DB::raw('DAY(`created_at`)'))
            ->groupBy(DB::raw('branch_id'))->get([
                DB::raw('SUM(IF(type=\'+\', `amount`, 0)) as `add`'),
                DB::raw('SUM(IF(type=\'-\', `amount`, 0)) as `sub`'),
                DB::raw('YEAR(`created_at`) as `year`'),
                DB::raw('MONTH(`created_at`) as `month`'),
                DB::raw('DAY(`created_at`) as `day`'),
                DB::raw('`branch_id`'),
            ]);

        return view('statistics.ledger.daily', compact('branches', 'ledgers', 'year', 'month'));
    }
}
