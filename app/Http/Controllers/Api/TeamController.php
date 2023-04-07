<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\{UpdateTeamRequest, CreateTeamRequest};
use App\Repositories\TeamRepository;

class TeamController extends Controller
{
    protected $repository;

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getAll()
    {
        return $this->repository->allData();
    }
    public function create(CreateTeamRequest $request)
    {
        return $this->repository->createData($request);
    }
    public function update(UpdateTeamRequest $request, $id)
    {
        return $this->repository->updateData($request, $id);
    }
    public function destroy($id)
    {
        return $this->repository->deleteData($id);
    }
}
