<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;

class RolesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Role::all();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Guard',
            'created_at',
            'updated_at',
        ];
    }
}
