<?php

namespace GymManager\Forms\Member;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Support\Facades\Auth;

class CreateMemberForm extends Form
{
    public function buildForm()
    {
        $currentUser = Auth::user();

        $this->add('name', 'text', [
            'label' => '이름',
            'rules' => 'required|min:2',
        ]);

        $this->add('address', 'text', [
            'label' => '주소',
            'rules' => 'required',
        ]);

        $this->add('weight', 'number', [
            'label' => '몸무게',
            'rules' => 'required',
        ]);

        $this->add('height', 'number', [
            'label' => '키',
            'rules' => 'required',
        ]);

        $this->add('bdate', 'date', [
            'label' => '생년월일',
            'rules' => 'required',
        ]);

        $this->add('regdate', 'date', [
            'label' => '등록일',
            'rules' => 'required',
        ]);

        $this->add('memo', 'text', [
            'label' => '메모',
            'rules' => 'required',
        ]);


        $this->add('branch_id', 'select', [
            'label' => '지점선택',
            'rules' => 'required|exists:branches,id',
            'choices' => $currentUser->branches->pluck('name', 'id')->toArray(),
            'empty_value' => '등록할 지점을 선택하세요.',
        ]);
    }
}
