<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\role;
use App\Helpers\ResponseFormatter;
use App\Helpers\ConstantaFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
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
