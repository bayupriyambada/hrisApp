<?php

namespace App\Repositories;

use App\Helpers\ConstantaFormatter;
use Exception;
use App\Models\User;
use App\Models\Company;
use App\Helpers\ResponseFormatter;
use App\Helpers\UploadFileFormatter;
use Illuminate\Support\Facades\Auth;

class CompanyRepository
{
    public function allData()
    {
        $id = request()->input('id');
        $name = request()->input('name');
        $limit = request()->input('limit', 10);
        $companyQuery = Company::with(['users'])->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        });
        if ($id) {
            $company = $companyQuery->find($id);
            if ($company) {
                return ResponseFormatter::success($company, ConstantaFormatter::FOUND);
            }
            return ResponseFormatter::error(ConstantaFormatter::NOT_FOUND, 404);
        }
        $companies = $companyQuery;

        if ($name) {
            $companies->where('name', 'LIKE', '%' . $name . '%');
        }
        return ResponseFormatter::success($companies->paginate($limit), ConstantaFormatter::FOUND);
    }

    public function createData($params)
    {
        try {
            $company = Company::create([
                'name' => $params->name,
                'logo' => UploadFileFormatter::uploadFile('logo'),
            ]);

            if (!$company) {
                return ResponseFormatter::error(ConstantaFormatter::WRONG);
            }
            // attach company to user
            $user = User::find(Auth::id());
            $user->companies()->attach($company->id);

            // load user after attach
            $company->load('users');
            return ResponseFormatter::success($company, ConstantaFormatter::CREATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function updateData($params, $id)
    {
        try {
            $company = Company::find($id);
            if (!$company) {
                throw new Exception(ConstantaFormatter::NOT_FOUND);
            }
            $company->update([
                'name' => $params->name,
                'logo' => UploadFileFormatter::uploadFile('logo'),
            ]);
            return ResponseFormatter::success($company, ConstantaFormatter::UPDATED);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
