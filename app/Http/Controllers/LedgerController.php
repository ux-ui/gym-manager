<?php

namespace GymManager\Http\Controllers;

use GymManager\Models\Ledger;
use Illuminate\Support\Facades\Auth;
use GymManager\Forms\Ledger\EditLedgerForm;
use GymManager\Forms\Ledger\CreateLedgerForm;
use GymManager\Repositories\LedgerRepository;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Prettus\Repository\Criteria\RequestCriteria;
use GymManager\Repositories\Criteria\OrderByCriteria;

class LedgerController extends Controller
{
    use FormBuilderTrait;

    protected const PAGINATE_LIMIT = 20;

    /**
     * Ledger repository implements.
     *
     * @var \GymManager\Repositories\LedgerRepository
     */
    protected $ledger;

    /**
     * Create a new controller instance.
     *
     * @param  \GymManager\Repositories\LedgerRepository $ledger
     * @return void
     */
    public function __construct(LedgerRepository $ledger)
    {
        $this->ledger = $ledger;

        $this->middleware('auth');
    }

    /**
     * Displaying a listing of the ledgers.
     *
     * @return \Illuminate\Http\Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index()
    {
        $this->ledger->with(['branch', 'user']);
        $this->ledger->pushCriteria(resolve(RequestCriteria::class));
        $this->ledger->pushCriteria(new OrderByCriteria('updated_at', 'desc'));
        $ledgers = $this->ledger->paginate(self::PAGINATE_LIMIT);

        return view('ledger.index', compact('ledgers'));
    }

    /**
     * Display the specified ledger.
     *
     * @param  \GymManager\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        $ledger->load(['branch', 'user']);

        return view('ledger.show', compact('ledger'));
    }

    /**
     * Show the form for creating a new ledger.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(CreateLedgerForm::class, [
            'method' => 'POST',
            'url' => route('ledger.store'),
        ]);

        return view('ledger.create', compact('form'));
    }

    /**
     * Store a newly created ledger in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $form = $this->form(CreateLedgerForm::class);
        $form->redirectIfNotValid();

        $ledger = $this->ledger->create(array_merge($form->getFieldValues(), [
            'user_id' => Auth::user()->id,
        ]));

        return redirect()->route('ledger.show', [$ledger]);
    }

    /**
     * Show the form for editing the specified ledger.
     *
     * @param  \GymManager\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        $form = $this->form(EditLedgerForm::class, [
            'method' => 'PUT',
            'url' => route('ledger.update', [$ledger]),
            'model' => $ledger,
        ]);

        return view('ledger.edit', compact('form', 'ledger'));
    }

    /**
     * Update the specified ledger in storage.
     *
     * @param  \GymManager\Models\Ledger  $ledger
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Ledger $ledger)
    {
        $form = $this->form(EditLedgerForm::class);
        $form->redirectIfNotValid();

        $this->ledger->update($form->getFieldValues(), $ledger->id);

        return redirect()->route('ledger.show', [$ledger]);
    }

    /**
     * Remove the specified ledger from storage.
     *
     * @param  \GymManager\Models\Ledger  $ledger
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ledger $ledger)
    {
        $this->ledger->delete($ledger->id);

        return redirect()->route('ledger.index');
    }
}
