<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RolesExport;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-role')->only('index', 'exportPdf', 'print', 'exportExcel');
        $this->middleware('can:show-role')->only('show');
        $this->middleware('can:delete-role')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $rolesQuery = Role::query();

        if ($search) {
            $rolesQuery->where('name', 'like', '%' . $search . '%');
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $rolesQuery->orderBy($sortBy, $sortOrder);

        $roles = $rolesQuery->paginate(10);

        $title = 'Delete Role!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('dashboard.role.index', compact('roles'));
    }

    public function exportPdf()
    {
        $roles = Role::all();
        $title = 'Role Data';

        $pdf = pdf::loadView('exports.roleOrPermissionData', [
            'roles' => $roles,
            'title' => $title,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('role-data.pdf');
    }

    public function print()
    {
        $roles = Role::all();
        $title = 'Role Data';

        $pdf = pdf::loadView('exports.roleOrPermissionData', [
            'roles' => $roles,
            'title' => $title,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('role-data.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new RolesExport, 'role-data.xlsx');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $role = Role::with('users')->where('name', $name)
            ->firstOrFail();

        return view('dashboard.role.show', compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        Role::where('uuid', $uuid)->firstOrFail()->delete();
        Alert::success('Delete Role', 'Role Data Deleted Successfully!');

        return redirect()->back();
    }
}
