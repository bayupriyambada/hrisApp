<?php

namespace App\Repositories;

use Exception;
use App\Models\Role;
use App\Helpers\ResponseFormatter;
use App\Helpers\ConstantaFormatter;

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
                return ResponseFormatter::success($role, ConstantaFormatter::FOUND);
            }

            return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
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
                return ResponseFormatter::error(ConstantaFormatter::WRONG);
            }
            return ResponseFormatter::success($role, ConstantaFormatter::CREATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function updateData($params, $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                throw new Exception(ConstantaFormatter::NOT_FOUND);
            }

            $role->update([
                'name' => $params->name,
                'company_id' => $params->company_id
            ]);

            return ResponseFormatter::success($role, ConstantaFormatter::UPDATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function deleteData($id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
            }
            $role->delete();

            return ResponseFormatter::success(ConstantaFormatter::DELETE);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
