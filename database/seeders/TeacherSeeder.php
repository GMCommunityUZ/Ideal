<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Teacher',
            'title' => 'Teacher',
            'guard_name' => 'web'
        ]);

        $permissions = Permission::insert([
            [
                'name'=>'teacher.show',
                'title'=>"Ustozlarni ko'rish",
                'guard_name'=>'web'
            ],
            [
                'name'=>'teacher.edit',
                'title'=>"Ustozni tahrirlash",
                'guard_name'=>'web'
            ],
            [
                'name'=>'teacher.add',
                'title'=>"Ustoz qo'shish",
                'guard_name'=>'web'
            ],
            [
                'name'=>'teacher.delete',
                'title'=>"Ustozni o'chirish",
                'guard_name'=>'web'
            ]
        ]);


    }
}
