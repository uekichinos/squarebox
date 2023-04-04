<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = [];
        $data = Role::all();
        if(count($data) > 0) {
            foreach ($data as $key => $value) {
                $user = User::role($value->name)->get();
                $roles[$value->name] = count($user);
            }
        }
        return view('dashboard', compact('roles'));
    }
}
