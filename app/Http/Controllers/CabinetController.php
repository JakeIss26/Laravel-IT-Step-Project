<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabinet;

class CabinetController extends Controller
{
    public function hello(){    
        echo "Hello";
    }

    public function create(Request $request) {
        $cabinet = new Cabinet();

        $cabinet->name = 'php cabinet';
        $cabinet->number = 1826;
        $cabinet->save();
        return $cabinet;
    }

    public function get() {
        $users = Cabinet::all();
        return $users;
    }

    public function getById($id) {
        $user = Cabinet::find($id);
        return $user;
    }

    public function post(Request $request) {
        $cabinet = new Cabinet();

        $cabinet->name = $request->name;
        $cabinet->number = $request->number;
        $cabinet->save();
        echo "Post";
        return $cabinet;
    }

    public function put(Request $request, $id) {
        $user = Cabinet::find($id);
        $user->name = $request->name;
        $user->number = $request->number;
        $user->save();
        return $user;
    }

    public function delete($id) {
        $user = Cabinet::find($id);
        $user->delete();
        echo "Delete";
    }
}
