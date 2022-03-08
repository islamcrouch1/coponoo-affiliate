<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function headings(): array
    {

        return [
            'id',
            'created_at',
            'name',
            'phone',
            'email',
            'status',
            'gender',
            'type'
        ];
    }


    public function collection()
    {

        return collect(User::getUsers());
    }
}
