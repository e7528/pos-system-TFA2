<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        $data = [
            'title' => 'User Accounts | SwiftPOS',
            'users' => $userModel
                ->select(['id', 'username', 'full_name', 'role', 'attendance_status', 'is_verified'])
                ->orderBy('id', 'ASC')
                ->findAll(),
        ];

        return view('templates/header', $data)
             . view('users/index', $data)
             . view('templates/footer');
    }
}
