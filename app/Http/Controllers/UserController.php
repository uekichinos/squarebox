<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Http\Request;
use App\Models\PasswordHistory;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdatePasswordUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Get list of users
     */
    public function getList(Request $request) 
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function($row) {
                    return ucwords($row->name).(Cache::get('user-is-online-'.$row->id) === true ? ' <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z" /></svg>' : '');
                })
                ->addColumn('action', function($row) {
                    $user = Auth::user();

                    $viewbtn = '<a href="'.route('user.show', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></a>';
                    $editbtn = '<a href="'.route('user.edit', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></a>';
                    $deletebtn = '<a href="'.route('user.destroy', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></a>';
                    $personatebtn = '<a href="'.route('user.takeimpersonate', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></a>';
                    
                    $actionbtn = ($user->can('View User') ? $viewbtn : '').($user->can('Update User') ? $editbtn : '').($user->can('Delete User') && $user->id != $row->id ? $deletebtn : '').($user->can('Impersonate User') && $user->id != $row->id ? $personatebtn : '');

                    return $actionbtn;
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* roles */
        $roles = Role::all();
        
        return view('user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {   
        $request = $request->validated();

		$role = Role::find($request['role']);

		$user = new User();
		$user->name = $request['name'];
		$user->email = $request['email'];
		$user->password = Hash::make($request['password']);
		$user->save();
		$user->roles()->attach($role);

        return redirect()->route('user.index')->with('success', 'User <strong>'.$request['name'].'</strong> created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /* get user */
        $user = User::find($id);
        $role = $user->getRoleNames()[0];

        /* roles */
        $roles = Role::all();

        return view('user.show', ['user' => $user, 'role' => $role, 'roles' => $roles]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /* get user */
        $user = User::find($id);
        $role = $user->roles->first()->id;

        /* roles */
        $roles = Role::all();

        return view('user.edit', ['user' => $user, 'roleid' => $role, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $request = $request->validated();
        
		$role = Role::find($request['role'])->first();
        
		$user = User::find($id);
		$user->name = $request['name'];
		$user->email = $request['email'];
		$user->save();
		$user->syncRoles($role);

        return redirect()->route('user.edit', $id)->with('success', 'User <strong>'.$request['name'].'</strong> updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User <strong>'.$user->name.'</strong> deleted successfully!');
    }

    /**
     * Show the form for editing password.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword($id)
    {
        /* get user */
        $user = User::find($id);

        return view('user.editpassword', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdatePasswordUserRequest $request, $id)
    {
        $request = $request->validated();

        $user = User::find($id);

		$user->password = Hash::make($request['password']);
        $user->password_updated_at = date("Y-m-d H:i:s");
		$user->save();

        PasswordHistory::capturePassword($request['password']);
        
        return redirect()->route('user.editpassword', $id)->with('success', 'Password for user <strong>'.$user->name.'</strong> updated successfully!');
    }

    /**
     * Impersonate user
     */
    public function TakeImpersonate($id) 
    {
        $user = User::find($id);
        Auth::user()->impersonate($user);

        return redirect(config('laravel-impersonate.take_redirect_to'));
    }

    /**
     * Revert impersonate to previous user
     */
    public function LeaveImpersonate() 
    {
        Auth::user()->leaveImpersonation();

        return redirect(config('laravel-impersonate.leave_redirect_to'));
    }
}
