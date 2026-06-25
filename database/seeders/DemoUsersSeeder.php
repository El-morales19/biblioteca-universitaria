<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // Admins
            [
                'name' => 'Administrador General',
                'email' => 'admin@biblioteca.com',
                'role' => 'admin',
                'active' => true,
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.admin@biblioteca.com',
                'role' => 'admin',
                'active' => true,
            ],

            // Bibliotecarios
            [
                'name' => 'Carlos Hernández',
                'email' => 'carlos.bibliotecario@biblioteca.com',
                'role' => 'bibliotecario',
                'active' => true,
            ],
            [
                'name' => 'María López',
                'email' => 'maria.bibliotecario@biblioteca.com',
                'role' => 'bibliotecario',
                'active' => true,
            ],

            // Alumnos
            [
                'name' => 'Luis Ramírez',
                'email' => 'luis.ramirez@alumno.unam.mx',
                'role' => 'alumno',
                'active' => true,
            ],
            [
                'name' => 'Sofía Torres',
                'email' => 'sofia.torres@alumno.unam.mx',
                'role' => 'alumno',
                'active' => true,
            ],
            [
                'name' => 'Diego Morales',
                'email' => 'diego.morales@alumno.unam.mx',
                'role' => 'alumno',
                'active' => true,
            ],
            [
                'name' => 'Fernanda Cruz',
                'email' => 'fernanda.cruz@alumno.unam.mx',
                'role' => 'alumno',
                'active' => true,
            ],
            [
                'name' => 'Jorge Castillo',
                'email' => 'jorge.castillo@alumno.unam.mx',
                'role' => 'alumno',
                'active' => true,
            ],
            [
                'name' => 'Valeria Gómez',
                'email' => 'valeria.gomez@alumno.unam.mx',
                'role' => 'alumno',
                'active' => true,
            ],

            // Inactivos
            [
                'name' => 'Alumno Inactivo 1',
                'email' => 'inactivo1@alumno.unam.mx',
                'role' => 'alumno',
                'active' => false,
            ],
            [
                'name' => 'Alumno Inactivo 2',
                'email' => 'inactivo2@alumno.unam.mx',
                'role' => 'alumno',
                'active' => false,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'active' => $user['active'],
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}