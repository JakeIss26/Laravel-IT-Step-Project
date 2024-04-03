<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Services\GroupService;
use App\Http\Requests\GroupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    protected $groupService;

    public function __construct()
    {
        
        $this->groupService = new GroupService();
        $this->user = Auth::user();
        $this->middleware('jwt.auth');
    }

    public function index() {
        $groups = $this->groupService->getGroups();
        return $groups;
    }

    public function show(string $id) {
        $group = $this->groupService->showGroup($id);
        return $group;
    }

    public function store(GroupRequest $request) {
        $user = Auth::user();
        $data = $request->all();

        $group = $this->groupService->addGroup($data, $user);

        return $group;
    }

    public function destroy(string $id) {
        $response = $this->groupService->deleteGroup($id);
        return $response;
    }

    public function update(GroupRequest $request, string $id)
    {
        $user = Auth::user();
        $data = $request->all();

        $group = $this->groupService->updateGroup($data, $user, $id);

        return $group;
    }
    
}
