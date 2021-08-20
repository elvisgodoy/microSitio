<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = new User();
        $usuario->name = "Juan";
        $usuario->last_name = "Perez";
        $usuario->email = "admin@admin.com";
        $usuario->password = Hash::make("contraseña");
        $usuario->role = 1;
        $usuario->save(); 
    }
}
