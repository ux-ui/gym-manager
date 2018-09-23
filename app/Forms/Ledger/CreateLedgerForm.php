<?php

namespace GymManager\Forms\Ledger;

use GymManager\Models\Branch;
use Kris\LaravelFormBuilder\Form;

class CreateLedgerForm extends Form
{
    public function buildForm()
    {
        $this->add('type', 'choice', [
            'label' => '구분',
            'rules' => 'required|in:+,-',
            'choices' => ['+' => '+', '-' => '-'],
            'expanded' => true,
            'multiple' => false,
        ]);

        $this->add('branch_id', 'select', [
            'label' => '지점',
            'rules' => 'required|exists:branches,id',
            'choices' => Branch::all()->pluck('name', 'id')->toArray(),
            'empty_value' => '등록할 지점을 선택하세요.',
        ]);

        $this->add('purpose', 'text', [
            'label' => '내용',
            'rules' => 'required|min:4',
        ]);

        $this->add('amount', 'text', [
            'label' => '금액',
            'rules' => 'required|integer',
        ]);
    }
}
