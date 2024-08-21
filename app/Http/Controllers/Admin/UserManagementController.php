<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:create-user')->only('show', 'store');
        $this->middleware('can:edit-user')->only('update', 'resetPassword');
        $this->middleware('can:give-permission')->only('updatePermissions');
        $this->middleware('can:actived-user')->only('activedUser');
        $this->middleware('can:delete-user')->only('destory');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $usersQuery = User::with('roles');

        if ($search) {
            $usersQuery->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('roles', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['name', 'email', 'username', 'created_at'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'name';
        }

        $usersQuery->orderBy($sortBy, $sortOrder);

        $users = $usersQuery->paginate(10);

        $roles = Role::all();

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('dashboard.user.index', compact('users', 'roles'));
    }

    public function exportExcel()
    {
        return Excel::download(new UserExport, 'user-data.xlsx');
    }

    public function print()
    {
        $users = User::with('roles')->get();

        $pdf = pdf::loadView('exports.usersData', [
            'users' => $users,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('users-data.pdf');
    }


    public function exportPdf()
    {
        $users = User::with('roles')->get();

        $pdf = pdf::loadView('exports.usersData', [
            'users' => $users,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('users-data.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|string',
            'username' => 'required|alpha_num|min:5|max:150|string|unique:users,username',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'password_confirmation' => 'required|same:password',
            'role' => 'required|exists:roles,uuid',
            'permission' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $role = Role::where('uuid', $validated['role'])->first();
        if ($role) {
            $user->assignRole($role->name);
        }

        if ($request->filled('permission')) {
            $permissions = Permission::all();
            $user->syncPermissions($permissions);
        }

        Alert::success('Create Data', 'User Data Created Successfully!.');
        return redirect()->route('user.index')->with('success', 'User has been created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $name = str_replace('-', ' ', $slug);
        $user = User::with('roles', 'permissions')->where('name', $name)->firstOrFail();
        $allPermissions = Permission::all();
        $hasAllPermissions = $user->permissions->count() === $allPermissions->count();

        return view('dashboard.user.show', compact('user', 'allPermissions', 'hasAllPermissions'));
    }

    public function updatePermissions(Request $request, string $slug)
    {
        $validator = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'uuid',
        ]);

        $name = str_replace('-', ' ', $slug);
        $user = User::where('name', $name)->firstOrFail();

        $action = $request->input('action');

        if ($action === 'give-all') {
            $permissions = Permission::all();
            $user->syncPermissions($permissions);
        } elseif ($action === 'give-selected') {
            $selectedPermissions = $request->input('permissions', []);

            $user->syncPermissions([]);

            if (!empty($selectedPermissions)) {
                $permissions = Permission::whereIn('uuid', $selectedPermissions)->get();
                $user->givePermissionTo($permissions);
            }
        }

        Alert::success('Give Permission User', 'Permission has been gived successfully!');
        return redirect()->route('user.show', ['slug' => Str::slug($user->name)])->with('success', 'Permissions updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $name = str_replace('-', ' ', $slug);
        $user = User::where('name', $name)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|max:150|string',
            'username' => 'required|alpha_num|min:5|max:150|string|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:100',
        ]);

        $user->update($validated);

        Alert::success('User Data Updated', 'User data has been updated successfully!');
        return redirect()->route('user.show', ['slug' => Str::slug($user->name)]);
    }

    public function resetPassword(Request $request, string $slug)
    {
        $request->validate([
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'confirmation_password' => 'required|same:new_password',
        ]);

        $name = str_replace('-', ' ', $slug);
        $user = User::where('name', $name)->firstOrFail();

        $user->update([
            'password' => bcrypt($request->input('new_password')),
        ]);

        Alert::success('Password Reset', 'Password has been updated successfully!');
        return redirect()->route('user.show', ['slug' => Str::slug($user->name)]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        Alert::success('Delete User', 'User Data Deleted Sucessfully!');

        return redirect()->route('user.index');
    }

    public function activedUser(string $slug)
    {
        // 
    }
}
