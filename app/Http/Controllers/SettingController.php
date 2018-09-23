<?php

namespace GymManager\Http\Controllers;

use GymManager\Forms\SettingForm;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class SettingController extends Controller
{
    use FormBuilderTrait;

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
     * Displaying the setting form view.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit()
    {
        $this->authorize('only-admin');

        $form = $this->form(SettingForm::class, [
            'method' => 'POST',
            'url' => route('setting'),
        ]);

        return view('setting', compact('form'));
    }

    /**
     * Update the setting attributes in storage.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update()
    {
        $this->authorize('only-admin');

        $form = $this->form(SettingForm::class);
        $form->redirectIfNotValid();

        foreach ($form->getFieldValues() as $key => $value) {
            setting([str_replace('_', '.', $key) => $value])->save();
        }

        return redirect()->route('setting');
    }
}
