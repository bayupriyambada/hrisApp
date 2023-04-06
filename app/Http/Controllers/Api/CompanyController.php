<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public $companyRepository;
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAll()
    {
        return $this->companyRepository->allData();
    }

    public function create(CreateCompanyRequest $request)
    {
        return $this->companyRepository->createCompany($request);
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        return $this->companyRepository->updateCompany($request, $id);
    }
}
