<?php

namespace App\Repositories;

use App\Helpers\ConstantaFormatter;
use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use App\Helpers\ResponseFormatter;
use App\Helpers\UploadFileFormatter;
use Illuminate\Support\Facades\Auth;

class TeamRepository
{
    public function all()
    {
        $id = request()->input('id');
        $name = request()->input('name');
        $limit = request()->input('limit', 10);
        $teamQuery = Team::query();

        if ($id) {
            $team = $teamQuery->find($id);
            if ($team) {
                return ResponseFormatter::success($team, ConstantaFormatter::FOUND);
            }
            return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
        }

        $teams = $teamQuery->where('company_id', request()->company_id);

        if ($name) {
            $teams->where('name', 'LIKE', '%' . $name . '%');
        }
        return ResponseFormatter::success($teams->paginate($limit), ConstantaFormatter::FOUND);
    }

    public function createData($params)
    {
        try {
            $team = Team::create([
                'name' => $params->name,
                'icon' => UploadFileFormatter::uploadFile('icon'),
                'company_id' => $params->company_id
            ]);

            if (!$team) {
                return ResponseFormatter::error(ConstantaFormatter::WRONG);
            }
            return ResponseFormatter::success($team, ConstantaFormatter::CREATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function updateData($params, $id)
    {
        try {
            $team = Team::find($id);
            if (!$team) {
                throw new Exception(ConstantaFormatter::NOT_FOUND);
            }
            $team->update([
                'name' => $params->name,
                'icon' => UploadFileFormatter::uploadFile('icon'),
                'company_id' => $params->company_id
            ]);

            return ResponseFormatter::success($team, ConstantaFormatter::UPDATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function deleteData($params)
    {
        try {
            $team = Team::find($params);
            if (!$team) {
                return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
            }
            $team->delete();
            return ResponseFormatter::success(ConstantaFormatter::DELETE);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
