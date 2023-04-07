<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\{UpdateRoleRequest, CreateRoleRequest};
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->allData();
    }
    public function create(CreateRoleRequest $request)
    {
        return $this->repository->createData($request);
    }
    public function update(UpdateRoleRequest $request, $id)
    {
        return $this->repository->updateData($request, $id);
    }
    public function destroy($id)
    {
        return $this->repository->deleteData($id);
    }
}
