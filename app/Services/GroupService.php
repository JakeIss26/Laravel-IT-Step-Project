<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupService {

    public function getGroups() {
        $groups = Group::all();
        return $groups;
    }

    public function showGroup(string $id) {
        $group = Group::findOrFail($id);
        return $group;
    }

    public function addGroup($data, $user) {
        $data['owner'] = $user->id;
        $group = Group::create($data);
        return $group;
    }

    public function deleteGroup(string $id) {
        $group = Group::findOrFail($id);
        $group->delete();
        return response()->json(['message' => 'Delete successfully'], 200);
    }

    public function updateGroup($data, $user, string $id)
    {
        $group = Group::findOrFail($id);
        $data['owner'] = $user->id;
        $group->update($data);

        return $group;
    }
}