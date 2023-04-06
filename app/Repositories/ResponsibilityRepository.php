<?php

namespace App\Repositories;

use Exception;
use App\Models\Team;
use App\Models\Responsibility;
use App\Helpers\ResponseFormatter;
use App\Helpers\UploadFileFormatter;

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
                return ResponseFormatter::success($responsibility, 'Responsibility Found');
            }
            return ResponseFormatter::error('Responsibility not found', 404);
        }
        $responsibilitys = $ResponsibilityQuery->where('role_id', request()->role_id);
        if ($name) {
            $responsibilitys->where('name', 'LIKE', '%' . $name . '%');
        }
        return ResponseFormatter::success($responsibilitys->paginate($limit), 'responsibility Found');
    }

    public function createData($params)
    {
        try {
            $Responsibility = Responsibility::create([
                'name' => $params->name,
                'role_id' => $params->role_id
            ]);
            if (!$Responsibility) {
                return ResponseFormatter::error('Something wrong created!');
            }
            return ResponseFormatter::success($Responsibility, 'Responsibility created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function updateData($params, $id)
    {
        try {
            $team = Team::find($id);
            if (!$team) {
                throw new Exception('Team not found');
            }
            $team->update([
                'name' => $params->name,
                'icon' => UploadFileFormatter::uploadFile('icon'),
                'company_id' => $params->company_id
            ]);

            return ResponseFormatter::success($team, 'Role updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
