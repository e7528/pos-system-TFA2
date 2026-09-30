<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'     => 'Customer Accounts | SwiftPOS',
            'customers' => $customerModel
                ->select(['id', 'full_name', 'email', 'phone', 'status'])
                ->orderBy('id', 'ASC')
                ->findAll(),
        ];

        return view('templates/header', $data)
             . view('customers/index', $data)
             . view('templates/footer');
    }
}
