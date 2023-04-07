<?php

namespace App\Repositories;

use Exception;
use App\Models\Role;
use App\Models\Team;
use App\Helpers\ResponseFormatter;
use App\Helpers\ConstantaFormatter;
use App\Helpers\UploadFileFormatter;

class RoleRepository
{
    public function allData()
    {
        $id = request()->input('id');
        $name = request()->input('name');
        $limit = request()->input('limit', 10);
        $withResponsibilities = request()->input('withResponsibilities', false);

        $roleQuery = Role::query();

        // Get single data
        if ($id) {
            $role = $roleQuery->with('responsibilities')->find($id);

            if ($role) {
                return ResponseFormatter::success($role, 'Role found');
            }

            return ResponseFormatter::error('Role not found', 404);
        }

        // Get multiple data
        $roles = $roleQuery->where('company_id', request()->company_id);

        if ($name) {
            $roles->where('name', 'like', '%' . $name . '%');
        }

        if ($withResponsibilities) {
            $roles->with('responsibilities');
        }

        return ResponseFormatter::success($roles->paginate($limit), ConstantaFormatter::FOUND);
    }

    public function createData($params)
    {
        try {

            $role = Role::create([
                'name' => $params->name,
                'company_id' => $params->company_id
            ]);

            if (!$role) {
                return ResponseFormatter::error('Something wrong created!');
            }
            return ResponseFormatter::success($role, 'Role created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function updateData($params, $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                throw new Exception('Role not found');
            }

            $role->update([
                'name' => $params->name,
                'company_id' => $params->company_id
            ]);

            return ResponseFormatter::success($role, 'Role updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function deleteData($id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return ResponseFormatter::error('Role not found', 404);
            }
            $role->delete();

            return ResponseFormatter::success("Role Deleted");
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
