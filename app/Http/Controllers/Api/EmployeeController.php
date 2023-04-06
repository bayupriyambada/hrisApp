<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\employee;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;

class EmployeeController extends Controller
{


    public function getAll()
    {
        $id = request()->input('id');
        $name = request()->input('name');
        $email = request()->input('email');
        $age = request()->input('age');
        $phone = request()->input('phone');
        $role_id = request()->input('role_id');
        $team_id = request()->input('team_id');
        $company_id = request()->input('company_id');
        $limit = request()->input('limit', 10);
        $employeeQuery = employee::query();

        // Todo: if condition by id when search data found and not found for share result json
        if ($id) {
            $employee = $employeeQuery->with(['role', 'team'])->find($id);
            if ($employee) {
                return ResponseFormatter::success($employee, 'employee Found');
            }
            return ResponseFormatter::error('employee not found', 404);
        }

        // get multiple data
        $employees = $employeeQuery;

        $filtering = [
            'name' => $name
        ];

        $results = self::filtering($filtering, $employees);

        self::filtering($employees, $name, 'name');
        self::filtering($employees, $email, 'email');
        self::filtering($employees, $phone, 'phone');
        self::filtering($employees, $age, 'age');

        // if ($name) {
        //     $employees->where('name', 'LIKE', '%' . $name . '%');
        // }
        if ($email) {
            $employees->where('email', $email);
        }
        if ($age) {
            $employees->where('age', $age);
        }
        if ($phone) {
            $employees->where('phone', $phone);
        }
        if ($role_id) {
            $employees->where('role_id', $role_id);
        }
        if ($team_id) {
            $employees->where('team_id', $team_id);
        }
        if ($company_id) {
            $employees->whereHas('company', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            });
        }
        return ResponseFormatter::success($employees->paginate($limit), 'employee Found');
    }
    public function create(CreateEmployeeRequest $request)
    {
        try {
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/photos');
            }

            $employee = employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'age' => $request->age,
                'phone' => $request->phone,
                'team_id' => $request->team_id,
                'company_id' => $request->company_id,
                'gender' => $request->gender,
                'photo' => $path,
            ]);

            if (!$employee) {
                return ResponseFormatter::error('Something wrong created!');
            }
            return ResponseFormatter::success($employee, 'employee created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $employee = employee::find($id);
            if (!$employee) {
                throw new Exception('employee not found');
            }

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/photos');
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'age' => $request->age,
                'phone' => $request->phone,
                'team_id' => $request->team_id,
                'company_id' => $request->company_id,
                'gender' => $request->gender,
                'photo' => isset($path) ? $path : $employee->photo,
            ]);

            return ResponseFormatter::success($employee, 'Role updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = employee::find($id);
            if (!$employee) {
                return ResponseFormatter::error('employee not found', 404);
            }
            $employee->delete();

            return ResponseFormatter::success("employee Deleted");
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
    public static function filtering($filtering = [], $builder = null)
    {
        foreach ($filtering as $column => $value) {
            if (!is_null($value)) {
                $builder->where($column, 'LIKE', '%' . $value . '%')
                    ->orWhere($column, $value);
            }
        }
        return $builder;
    }
}
