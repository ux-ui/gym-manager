<?php

namespace GymManager\Forms;

use Kris\LaravelFormBuilder\Form;

class SettingForm extends Form
{
    public function buildForm()
    {
        $this->add('gym.name', 'text', [
            'label' => '센터명',
            'rules' => 'required',
            'value' => setting('gym.name'),
        ]);
    }
}
