<?php

namespace GymManager\Forms\Member;

use GymManager\Models\Branch;
use Kris\LaravelFormBuilder\Form;

class EditMemberForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => '지점명',
            'rules' => 'required|min:2',
        ]);

        $this->add('branch_id', 'select', [
            'label' => '지점선택',
            'rules' => 'required|exists:branches,id',
            'choices' => Branch::all()->pluck('name', 'id')->toArray(),
            'empty_value' => '등록할 지점을 선택하세요.',
        ]);
    }
}
