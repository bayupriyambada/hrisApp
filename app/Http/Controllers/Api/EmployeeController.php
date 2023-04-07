<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\{UpdateEmployeeRequest, CreateEmployeeRequest};
use App\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getAll()
    {
        return $this->repository->allData();
    }
    public function create(CreateEmployeeRequest $request)
    {
        return $this->repository->createData($request);
    }
    public function update(UpdateEmployeeRequest $request, $id)
    {
        return $this->repository->updateData($request, $id);
    }
    public function destroy($id)
    {
        return $this->repository->deleteData($id);
    }
}
