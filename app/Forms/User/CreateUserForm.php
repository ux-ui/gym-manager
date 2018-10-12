<?php

namespace GymManager\Forms\User;

use GymManager\Models\Branch;
use Kris\LaravelFormBuilder\Form;

class CreateUserForm extends Form
{
    public function buildForm()
    {
        $this->add('username', 'text', [
            'label' => '아이디',
            'rules' => 'required|min:4|unique:users,username',
        ]);

        $this->add('password', 'password', [
            'label' => '비밀번호',
            'rules' => 'required|min:6|confirmed',
        ]);

        $this->add('password_confirmation', 'password', [
            'label' => '비밀번호 재확인',
            'rules' => 'required',
        ]);

        $this->add('name', 'text', [
            'label' => '이름',
            'rules' => 'required|min:2',
        ]);

        $this->add('title', 'text', [
            'label' => '직책',
            'rules' => 'required',
        ]);

        $this->add('branch_id', 'choice', [
            'label' => '관리지점',
            'expanded' => true,
            'multiple' => true,
            'choice_options' => [
                'wrapper' => ['class' => 'choice-wrapper'],
                'label_attr' => ['class' => 'label-class'],
            ],
            'choices' => Branch::all()->pluck('name', 'id')->toArray(),
            'rules' => 'array|exists:branches,id',
        ]);
    }
}
