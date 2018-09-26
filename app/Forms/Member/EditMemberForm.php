<?php

namespace GymManager\Forms\Member;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Support\Facades\Auth;

class EditMemberForm extends Form
{
    public function buildForm()
    {
        $currentUser = Auth::user();

        $this->add('name', 'text', [
            'label' => '회원명',
            'rules' => 'required|min:2',
        ]);

        $this->add('branch_id', 'select', [
            'label' => '지점선택',
            'rules' => 'required|exists:branches,id',
            'choices' => $currentUser->branches->pluck('name', 'id')->toArray(),
            'empty_value' => '등록할 지점을 선택하세요.',
        ]);
    }
}
