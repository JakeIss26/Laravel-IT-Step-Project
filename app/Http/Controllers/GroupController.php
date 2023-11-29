<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function showGroups() {
        $groups = Group::all();
        return $groups;
    }

    public function getById($id) {
        $post = Group::find($id);
        return $post;
    }

    public function addGroup(Request $request) {
        $group = new Group();
        $group->description = $request->description;
        $group->owner = $request->owner;
        $group->save();

        return $group;
    }

    public function removeGroup($id) {
        $group = Group::find($id);
        $group->delete();

        return response('Delete successfully', 204);
    }

    public function updateGroup(Request $request, $groupId) {
        $group = Group::find($groupId);
        $group->update([
            'description' => $request->input('description', $group->description),
            'owner' => $request->input('owner', $group->owner),
        ]);

        return $group;
    }
}
