<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_uuid')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.uuid')
            ->select(['users.name', 'users.email', 'users.username', 'roles.name as role_name'])
            ->get();
    }


    /**
     * Menentukan header untuk kolom-kolom pada file Excel
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Username',
            'Role',
        ];
    }
}
