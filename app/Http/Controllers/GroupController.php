<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        // if (!$request->has('owner')) {
        //     return response()->json(['error' => 'The owner field is required.'], 422);
        // }

        // $ownerId = $request->input('owner');

        // Валидируем, что пользователь существует
        // if (!User::find($ownerId)) {
        //     return response()->json(['error' => 'Invalid owner.'], 422);
        // }
        
        $group = new Group();
        $group->description = $request->description;
        $group->owner = $user->id;
        $group->save();
        return response()->json([
            'description' => $group->description,
            'owner' => $group->owner,
        ], 201);
        // dd($post);
        // return $group;
    }

    public function destroy(Request $request, string $id) {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        if ($group->owner !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $group->delete();

        return response('Delete successfully', 204);
    }

    public function update(Request $request, string $id)
    {
        $group = Group::find($id);
    
        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }
    
        if ($group->owner !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Проверка, что владелец, переданный в запросе, существует
        if (!$request->has('owner') || !User::find($request->input('owner'))) {
            return response()->json(['message' => 'Invalid owner'], 422);
        }

        if (!$request->has('description') || $request->input('description') === null) {
            return response()->json(['message' => 'The description field is required.'], 422);
        }
    
        // Обновление группы
        $group->update([
            'description' => $request->input('description', $group->description),
            'owner' => $request->input('owner', $group->owner),
        ]);
    
        return $group;
    }
    
}
