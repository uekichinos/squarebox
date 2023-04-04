<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('role.index');
    }

    /**
     * Get list of roles
     */
    public function getList(Request $request) 
    {
        if ($request->ajax()) {
            $data = Role::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function($row) {
                    return ucwords($row->name).($row->default == 1 ? ' <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>' : '');
                })
                ->addColumn('action', function($row){
                    $user = Auth::user();

                    $viewbtn = '<a href="'.route('role.show', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></a>';
                    $editbtn = '<a href="'.route('role.edit', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></a>';
                    $deletebtn = '<a href="'.route('role.destroy', $row->id).'" class="inline-block pr-2 text-gray-500 hover:text-black"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></a>';
                    
                    $actionbtn = ($user->can('View Role') ? $viewbtn : '').($user->can('Update Role') ? $editbtn : '').($user->can('Delete Role') && $row->id != 1 ? $deletebtn : '');

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
        /* permission */
        $lists = [];
        $permissions = Permission::all();
        foreach($permissions as $key => $permission) {
            $exp = explode(' ', $permission->name);
            $lists[$exp[1]][] = array('name' => $permission->name);
        }
        
        return view('role.create', ['lists' => $lists]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $request = $request->validated();

        $default_role = 0;
        if(!empty($request['default'])) {
            $default_role = $request['default'];
            $records = Role::where('default', 1)->get();
            if(count($records) > 0) {
                foreach ($records as $record_key => $record_value) {
                    $record_value->default = 0;
                    $record_value->save();
                }
            }
        }

        $role = new Role();
        $role->name = strtolower($request['rolename']);
        $role->default = $default_role;
        $role->save();

        $permissions = $request['rolepermission'];
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $p = Permission::where('name', '=', $permission)->firstOrFail();
                $role = Role::where('name', '=', strtolower($request['rolename']))->first();
                $role->givePermissionTo($p);
            }
        }

        return redirect()->route('role.index')->with('success', 'Role <strong>'.$request['rolename'].'</strong> created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /* all role */
        $role = Role::find($id);

        /* permissions attached to this role */
        $permissionArr = [];
        $query = Role::where('id', $id)->with(['permissions'])->get();
        foreach($query as $key => $value) {
            foreach($value->permissions as $key => $permission) {
                $exp = explode(' ', $permission->name);
                $permissionArr[] = $permission->name;
            }
        }

        /* all permission */
        $permissions = [];
        $lists = Permission::all();
        foreach($lists as $key => $list) {
            
            $tag = false;
            if(in_array($list->name, $permissionArr)) {
                $tag = true;
            }

            $exp = explode(' ', $list->name);
            $permissions[$exp[1]][] = array(
                'name' => $list->name,
                'tag' => $tag,
            );
        }

        return view('role.show', ['permissions' => $permissions, 'role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /* all role */
        $role = Role::find($id);

        /* permissions attached to this role */
        $permissionArr = [];
        $query = Role::where('id', $id)->with(['permissions'])->get();
        foreach($query as $key => $value) {
            foreach($value->permissions as $key => $permission) {
                $exp = explode(' ', $permission->name);
                $permissionArr[] = $permission->name;
            }
        }

        /* all permission */
        $permissions = [];
        $lists = Permission::all();
        foreach($lists as $key => $list) {
            
            $tag = false;
            if(in_array($list->name, $permissionArr)) {
                $tag = true;
            }

            $exp = explode(' ', $list->name);
            $permissions[$exp[1]][] = array(
                'name' => $list->name,
                'tag' => $tag,
            );
        }

        return view('role.edit', ['permissions' => $permissions, 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $request = $request->validated();

        $default_role = 0;
        if(!empty($request['default'])) {
            $default_role = $request['default'];
            $records = Role::where('default', 1)->get();
            if(count($records) > 0) {
                foreach ($records as $record_key => $record_value) {
                    $record_value->default = 0;
                    $record_value->save();
                }
            }
        }
        
        $role = Role::find($id);
        $role->name = strtolower($request['rolename']);
        $role->default = $default_role;
        $role->save();

        $permissions = $request['rolepermission'];
        if (count($permissions) > 0) {
            $role->syncPermissions($permissions);
        }

        return redirect()->route('role.edit', $id)->with('success', 'Role <strong>'.$request['rolename'].'</strong> updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        
        if($id == 2) {
            return redirect()->route('role.index')->with('error', 'Role <strong>'.$role->rolename.'</strong> cannot be deleted!');
        }

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role <strong>'.$role->rolename.'</strong> deleted successfully!');
    }
}
