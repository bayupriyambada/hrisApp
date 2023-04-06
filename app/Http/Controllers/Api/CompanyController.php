<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;

class CompanyController extends Controller
{
    protected $repository;
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getAll()
    {
        return $this->repository->allData();
    }

    public function create(CreateCompanyRequest $request)
    {
        return $this->repository->createData($request);
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        return $this->repository->updateData($request, $id);
    }
}
