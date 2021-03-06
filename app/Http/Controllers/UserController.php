<?php

namespace GymManager\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use GymManager\Models\User;
use GymManager\Forms\User\EditUserForm;
use GymManager\Forms\User\CreateUserForm;
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', User::class);

        $this->user->pushCriteria(resolve(RequestCriteria::class));
        $this->user->pushCriteria(new OrderByCriteria('updated_at', 'desc'));
        $users = $this->user->paginate(self::PAGINATE_LIMIT);

        return view('user.index', compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @param  \GymManager\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $this->authorize('create', User::class);

        $form = $this->form(CreateUserForm::class);
        $form->redirectIfNotValid();

        $data = $form->getFieldValues();
        $data['password'] = Hash::make($data['password']);

        $user = $this->user->create($data);
        foreach ($data['branch_id'] as $id) {
            $user->branches()->attach($id);
        }

        return redirect()->route('user.show', [$user]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \GymManager\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', User::class);

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
     * @param  \GymManager\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user)
    {
        $this->authorize('update', User::class);

        $form = $this->form(EditUserForm::class);
        $form->redirectIfNotValid();

        $data = $form->getFieldValues();
        $data['password'] = Hash::make($data['password']);

        $this->user->update($data, $user->id);

        $user->branches()->detach();
        foreach ($data['branches'] as $id) {
            $user->branches()->attach($id);
        }

        return redirect()->route('user.index', [$user]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \GymManager\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);

        $this->user->delete($user->id);

        return redirect()->route('user.index');
    }
}
