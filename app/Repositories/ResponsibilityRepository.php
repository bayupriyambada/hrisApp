<?php

namespace App\Repositories;

use App\Helpers\ConstantaFormatter;
use Exception;
use App\Models\Responsibility;
use App\Helpers\ResponseFormatter;

class ResponsibilityRepository
{
    public function allData()
    {
        $id = request()->input('id');
        $name = request()->input('name');
        $limit = request()->input('limit', 10);
        $ResponsibilityQuery = Responsibility::query();
        if ($id) {
            $responsibility = $ResponsibilityQuery->find($id);
            if ($responsibility) {
                return ResponseFormatter::success($responsibility, ConstantaFormatter::FOUND);
            }
            return ResponseFormatter::error('Responsibility not found', 404);
        }
        $responsibilitys = $ResponsibilityQuery->where('role_id', request()->role_id);
        if ($name) {
            $responsibilitys->where('name', 'LIKE', '%' . $name . '%');
        }
        return ResponseFormatter::success($responsibilitys->paginate($limit), ConstantaFormatter::FOUND);
    }

    public function createData($params)
    {
        try {
            $responsibility = Responsibility::create([
                'name' => $params->name,
                'role_id' => $params->role_id
            ]);
            if (!$responsibility) {
                return ResponseFormatter::error(ConstantaFormatter::WRONG);
            }
            return ResponseFormatter::success($responsibility, ConstantaFormatter::CREATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function updateData($params, $id)
    {
        try {
            $responsibility = Responsibility::find($id);
            if (!$responsibility) {
                return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
            }
            $responsibility->update([
                'name' => $params->name,
                'role_id' => $params->role_id
            ]);
            return ResponseFormatter::success($responsibility, ConstantaFormatter::UPDATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function deleteData($id)
    {
        try {
            $responsibility = Responsibility::find($id);
            if (!$responsibility) {
                return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
            }
            $responsibility->delete();
            return ResponseFormatter::success(ConstantaFormatter::DELETE);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
