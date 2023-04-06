<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RequestFormatter;
use Exception;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Responsibility\CreateResponsibilityRequest;
use App\Http\Requests\Responsibility\UpdateResponsibilityRequest;
use App\Models\Responsibility;
use App\Repositories\ResponsibilityRepository;

class ResponsibilityController extends Controller
{
    public $response;

    public function _construct(ResponsibilityRepository $response)
    {
        $this->response = $response;
    }
    public function getAll()
    {
        return dd($this->response->allData());
    }
    public function create(CreateResponsibilityRequest $request)
    {
        try {
            $Responsibility = Responsibility::create([
                'name' => $request->name,
                'role_id' => $request->role_id
            ]);
            if (!$Responsibility) {
                return ResponseFormatter::error('Something wrong created!');
            }
            return ResponseFormatter::success($Responsibility, 'Responsibility created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // public function update(UpdateResponsibilityRequest $request, $id)
    // {
    //     try {
    //         $Responsibility = Responsibility::find($id);
    //         if (!$Responsibility) {
    //             throw new Exception('Responsibility not found');
    //         }

    //         $Responsibility->update([
    //             'name' => $request->name,
    //             'role_id' => $request->role_id
    //         ]);

    //         return ResponseFormatter::success($Responsibility, 'Responsibility updated');
    //     } catch (Except ion $e) {
    //         return ResponseFormatter::error($e->getMessage(), 500);
    //     }
    // }

    public function destroy($id)
    {
        try {
            $Responsibility = Responsibility::find($id);
            if (!$Responsibility) {
                return ResponseFormatter::error('Responsibility not found', 404);
            }
            $Responsibility->delete();

            return ResponseFormatter::success("Responsibility Deleted");
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
