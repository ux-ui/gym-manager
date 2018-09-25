<?php

namespace GymManager\Http\Controllers;

use Illuminate\Http\Request;
use GymManager\Models\Member;
use Illuminate\Support\Facades\Auth;
use GymManager\Forms\Member\EditMemberForm;
use GymManager\Forms\Member\CreateMemberForm;
use GymManager\Repositories\MemberRepository;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Prettus\Repository\Criteria\RequestCriteria;
use GymManager\Repositories\Criteria\OrderByCriteria;
use GymManager\Repositories\Criteria\OfRelatedBranchCriteria;

class MemberController extends Controller
{
    use FormBuilderTrait;

    protected const PAGINATE_LIMIT = 20;

    /**
     * Member repository implements.
     *
     * @var \GymManager\Repositories\MemberRepository
     */
    protected $member;

    /**
     * Create a new controller instance.
     *
     * @param  \GymManager\Repositories\MemberRepository $member
     * @return void
     */
    public function __construct(MemberRepository $member)
    {
        $this->member = $member;

        $this->middleware('auth');
    }

    /**
     * Displaying a listing of the members.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->member->with(['branch']);
        $this->member->pushCriteria(resolve(RequestCriteria::class));
        $this->member->pushCriteria(new OrderByCriteria('updated_at', 'desc'));

        $default = Auth::user()->branchesToPluckedArray('id');
        $branches = array_filter($request->get('branches', $default), function ($value) use ($default) {
            return in_array($value, $default);
        });
        $this->member->pushCriteria(new OfRelatedBranchCriteria($branches));

        $members = $this->member->paginate(self::PAGINATE_LIMIT);

        return view('member.index', compact('members'));
    }

    /**
     * Display the specified member.
     *
     * @param  \GymManager\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $member->load(['branch']);

        return view('member.show', compact('member'));
    }

    /**
     * Show the form for creating a new member.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(CreateMemberForm::class, [
            'method' => 'POST',
            'url' => route('member.store'),
        ]);

        return view('member.create', compact('form'));
    }

    /**
     * Store a newly created member in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $form = $this->form(CreateMemberForm::class);
        $form->redirectIfNotValid();

        $member = $this->member->create($form->getFieldValues());

        return redirect()->route('member.show', [$member]);
    }

    /**
     * Show the form for editing the specified member.
     *
     * @param  \GymManager\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $form = $this->form(EditMemberForm::class, [
            'method' => 'PUT',
            'url' => route('member.update', [$member]),
            'model' => $member,
        ]);

        return view('member.edit', compact('form', 'member'));
    }

    /**
     * Update the specified member in storage.
     *
     * @param  \GymManager\Models\Member  $member
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Member $member)
    {
        $form = $this->form(EditMemberForm::class);
        $form->redirectIfNotValid();

        $this->member->update($form->getFieldValues(), $member->id);

        return redirect()->route('member.show', [$member]);
    }

    /**
     * Remove the specified member from storage.
     *
     * @param  \GymManager\Models\Member  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Member $member)
    {
        $this->member->delete($member->id);

        return redirect()->route('member.index');
    }
}
