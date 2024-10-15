<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users->map(function($users) {
            return [
                'login' => $users->login,
                'surname' => $users->surname,
                'name' => $users->name,
                'email' => $users->email,
                'phone' => $users->phone,
                'address' => $users->address,
                'role' => $users->role->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ЛОГІН',
            'ПРІЗВИЩЕ',
            'ІМʼЯ',
            'ЕЛЕКТРОННА ПОШТА',
            'ТЕЛЕФОН',
            'АДРЕСА',
            'РОЛЬ',
        ];
    }
}
