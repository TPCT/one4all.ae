<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Company\Company;

class CompaniesController extends Controller
{
    public function index(){
        $companies = Company::active()->get();
        return $this->view('companies.index', [
            'companies' => $companies
        ]);
    }
}
