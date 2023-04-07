<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Responsibility\{UpdateResponsibilityRequest, CreateResponsibilityRequest};
use App\Repositories\ResponsibilityRepository;

class ResponsibilityController extends Controller
{
    protected $repository;

    public function __construct(ResponsibilityRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getAll()
    {
        return $this->repository->allData();
    }
    public function create(CreateResponsibilityRequest $request)
    {
        return $this->repository->createData($request);
    }
    public function update(UpdateResponsibilityRequest $request, $id)
    {
        return $this->repository->updateData($request, $id);
    }
    public function destroy($id)
    {
        return $this->repository->deleteData($id);
    }
}
