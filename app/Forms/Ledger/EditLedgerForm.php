<?php

namespace GymManager\Forms\Ledger;

use Kris\LaravelFormBuilder\Form;

class EditLedgerForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => '지점명',
            'rules' => 'required|min:2',
        ]);
    }
}
