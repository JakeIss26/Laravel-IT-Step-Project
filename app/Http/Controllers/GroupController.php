<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index() {
        $groups = Group::all();
        return $groups;
    }

    public function show(string $id) {
        $post = Group::find($id);
        return $post;
    }

    public function store(Request $request) {
        $group = new Group();
        $group->description = $request->description;
        $group->owner = $request->owner;
        $group->save();

        return $group;
    }

    public function destroy(string $id) {
        $group = Group::find($id);
        $group->delete();

        return response('Delete successfully', 204);
    }

    public function update(Request $request, string $id) {
        $group = Group::find($id);
        $group->update([
            'description' => $request->input('description', $group->description),
            'owner' => $request->input('owner', $group->owner),
        ]);

        return $group;
    }
}
