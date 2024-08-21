<?php

namespace App\Exports;

use App\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;

class PermissionsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Permission::all();
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
