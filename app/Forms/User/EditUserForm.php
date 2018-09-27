<?php

namespace GymManager\Forms\User;

use GymManager\Models\Branch;
use Kris\LaravelFormBuilder\Form;

class EditUserForm extends Form
{
    public function buildForm()
    {
        $this->add('username', 'static', [
            'label' => '아이디',
            'tag' => 'div',
            'attr' => ['class' => 'form-control-static'],
        ]);

        $this->add('password', 'password', [
            'label' => '비밀번호',
            'rules' => 'required|min:6|confirmed',
            'value' => '',
        ]);

        $this->add('password_confirmation', 'password', [
            'label' => '비밀번호 재확인',
            'rules' => 'required',
            'value' => '',
        ]);

        $this->add('name', 'text', [
            'label' => '이름',
            'rules' => 'required|min:2',
        ]);

        $this->add('title', 'text', [
            'label' => '직책',
            'rules' => 'required',
        ]);

        $this->add('branches', 'choice', [
            'label' => '관리지점',
            'expanded' => true,
            'multiple' => true,
            'choices' => Branch::all()->pluck('name', 'id')->toArray(),
            'rules' => 'array|exists:branches,id',
            'selected' => function ($data) {
                return $data ? array_pluck($data, 'id') : null;
            },
        ]);
    }
}
