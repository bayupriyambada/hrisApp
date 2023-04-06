<?php

namespace App\Repositories;

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
                return ResponseFormatter::success($team, 'Team Found');
            }
            return ResponseFormatter::error('Team not found', 404);
        }

        $teams = $teamQuery->where('company_id', request()->company_id);

        if ($name) {
            $teams->where('name', 'LIKE', '%' . $name . '%');
        }
        return ResponseFormatter::success($teams->paginate($limit), 'Team Found');
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
                return ResponseFormatter::error('Something wrong created!');
            }
            return ResponseFormatter::success($team, 'Team created');
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

    public function deleteData($params)
    {
        try {
            $team = Team::find($params);
            if (!$team) {
                return ResponseFormatter::error('Team not found', 404);
            }
            $team->delete();

            return ResponseFormatter::success("Team Deleted");
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
