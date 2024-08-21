<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PermissionsExport;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view-permission')->only('view-permission', 'view-permission', 'view-permission', 'view-permission');
        $this->middleware('can:delete-permission')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $permissionQuery = Permission::query();

        if ($search) {
            $permissionQuery = Permission::where('name', 'like', '%' . $search . '%');
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $permissionQuery->orderBy($sortBy, $sortOrder);

        $permissions = $permissionQuery->paginate(10);

        $title = 'Delete Permission!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('dashboard.permission.index', compact('permissions'));
    }

    public function exportPdf()
    {
        $roles = Permission::all();
        $title = 'Permission Data';

        $pdf = pdf::loadView('exports.roleOrPermissionData', [
            'roles' => $roles,
            'title' => $title,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('permission-data.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PermissionsExport, 'permission-data.xlsx');
    }

    public function print()
    {
        $roles = Permission::all();
        $title = 'Permission Data';

        $pdf = Pdf::loadView('exports.roleOrPermissionData', [
            'roles' => $roles,
            'title' => $title,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('permission-data.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        Permission::where('uuid', $uuid)->firstOrFail()->delete();
        Alert::success('Delete Permission', 'Permission Data Deleted Successfully!');

        return redirect()->back();
    }
}
