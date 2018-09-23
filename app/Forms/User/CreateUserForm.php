<?php

namespace GymManager\Forms\User;

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
    }
}
