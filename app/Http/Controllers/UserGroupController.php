<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Group;
use Illuminate\Support\Facades\Auth;

class UserGroupController extends Controller
{

    public function index()
    {
        $usersInGroups = User_Group::all();
        return $userGroups;
    }


    public function store(Request $request)
    {
        $group = Group::find($request->group_id);
        if (!$group) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $userInGroup = new User_Group();
        $userInGroup->post_id = $request->post_id;
        $userInGroup->user_id = $request->user_id;
        $userInGroup->save();

        return $userInGroup;
    }


    public function show(string $id)
    {
        $usersInGroup = User_Group::find($id);
        return $usersInGroup;
    }


    // public function update(Request $request, string $id)
    // {
    //     $userInGroup = User_Group::where('group_id', $id)->first();
    
    //     if (!$group) {
    //         return response()->json(['message' => ' not found'], 404);
    //     }
    
    //     // Обновление группы
    //     $group->update([
    //         'group_id' => $request->input('description', $group->description),
    //         'owner' => $request->input('owner', $group->owner),
    //     ]);
    
    //     return $group;
    // }


    public function destroy(string $id)
    {
        $userInGroup = User_Group::where('group_id', $id)->first();


        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->delete();

        return response('Delete successfully', 204);
    }
}
