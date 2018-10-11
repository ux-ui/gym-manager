<?php

namespace GymManager\Http\Controllers;

use GymManager\Models\Branch;
use GymManager\Forms\Branch\EditBranchForm;
use GymManager\Forms\Branch\CreateBranchForm;
use GymManager\Repositories\BranchRepository;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Prettus\Repository\Criteria\RequestCriteria;
use GymManager\Repositories\Criteria\OrderByCriteria;

class BranchController extends Controller
{
    use FormBuilderTrait;

    protected const PAGINATE_LIMIT = 20;

    /**
     * Branch repository implements.
     *
     * @var \GymManager\Repositories\BranchRepository
     */
    protected $branch;

    /**
     * Create a new controller instance.
     *
     * @param  \GymManager\Repositories\BranchRepository $branch
     * @return void
     */
    public function __construct(BranchRepository $branch)
    {
        $this->branch = $branch;

        $this->middleware('auth');
    }

    /**
     * Displaying a listing of the branches.
     *
     * @return \Illuminate\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Branch::class);

        $this->branch->pushCriteria(resolve(RequestCriteria::class));
        $this->branch->pushCriteria(new OrderByCriteria('updated_at', 'desc'));
        $branches = $this->branch->paginate(self::PAGINATE_LIMIT);

        return view('branch.index', compact('branches'));
    }

    /**
     * Display the specified branch.
     *
     * @param  \GymManager\Models\Branch $branch
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Branch $branch)
    {
        $this->authorize('view', Branch::class);

        return view('branch.show', compact('branch'));
    }

    /**
     * Show the form for creating a new branch.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Branch::class);

        $form = $this->form(CreateBranchForm::class, [
            'method' => 'POST',
            'url' => route('branch.store'),
        ]);

        return view('branch.create', compact('form'));
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $this->authorize('create', Branch::class);

        $form = $this->form(CreateBranchForm::class);
        $form->redirectIfNotValid();

        $branch = $this->branch->create($form->getFieldValues());

        return redirect()->route('branch.show', [$branch]);
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  \GymManager\Models\Branch $branch
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Branch $branch)
    {
        $this->authorize('update', Branch::class);

        $form = $this->form(EditBranchForm::class, [
            'method' => 'PUT',
            'url' => route('branch.update', [$branch]),
            'model' => $branch,
        ]);

        return view('branch.edit', compact('form', 'branch'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  \GymManager\Models\Branch $branch
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Branch $branch)
    {
        $this->authorize('update', Branch::class);

        $form = $this->form(EditBranchForm::class);
        $form->redirectIfNotValid();

        $this->branch->update($form->getFieldValues(), $branch->id);

        return redirect()->route('branch.edit', [$branch]);
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  \GymManager\Models\Branch $branch
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Branch $branch)
    {
        $this->authorize('delete', Branch::class);

        $this->branch->delete($branch->id);

        return redirect()->route('branch.index');
    }
}
