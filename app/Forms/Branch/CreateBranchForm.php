<?php

namespace GymManager\Forms\Branch;

use Kris\LaravelFormBuilder\Form;

class CreateBranchForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => '지점명',
            'rules' => 'required|min:2',
        ]);
    }
}
