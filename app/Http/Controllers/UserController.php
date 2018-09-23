<?php

namespace GymManager\Http\Controllers;

use GymManager\Models\User;
use GymManager\Forms\EditUserForm;
use GymManager\Forms\CreateUserForm;
use GymManager\Repositories\UserRepository;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Prettus\Repository\Criteria\RequestCriteria;
use GymManager\Repositories\Criteria\OrderByCriteria;

class UserController extends Controller
{
    use FormBuilderTrait;

    protected const PAGINATE_LIMIT = 20;

    /**
     * User repository implements.
     *
     * @var \GymManager\Repositories\UserRepository
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param  \GymManager\Repositories\UserRepository $user
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;

        $this->middleware('auth');
    }

    /**
     * Displaying a listing of the users.
     *
     * @return \Illuminate\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index()
    {
        $this->user->pushCriteria(resolve(RequestCriteria::class));
        $this->user->pushCriteria(new OrderByCriteria('updated_at', 'desc'));
        $users = $this->user->paginate(self::PAGINATE_LIMIT);

        return view('user.index', compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @param  \GymManager\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(CreateUserForm::class, [
            'method' => 'POST',
            'url' => route('user.store'),
        ]);

        return view('user.create', compact('form'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $form = $this->form(CreateUserForm::class);
        $form->redirectIfNotValid();

        $user = $this->user->create($form->getFieldValues());

        return redirect()->route('user.show', [$user]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \GymManager\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $form = $this->form(EditUserForm::class, [
            'method' => 'PUT',
            'url' => route('user.update', [$user]),
            'model' => $user,
        ]);

        return view('user.edit', compact('form', 'user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \GymManager\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(User $user)
    {
        $form = $this->form(EditUserForm::class);
        $form->redirectIfNotValid();

        $this->user->update($form->getFieldValues(), $user->id);

        return redirect()->route('user.show', [$user]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \GymManager\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->user->delete($user->id);

        return redirect()->route('user.index');
    }
}
