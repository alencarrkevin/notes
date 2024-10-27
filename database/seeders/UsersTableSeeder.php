<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* create multiple users */
        DB::table('users')->insert([
            [
                'username' => 'kevin@gmail.com',
                'password' => bcrypt('abc123456'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kevin2@gmail.com',
                'password' => bcrypt('abc123456'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kevin3@gmail.com',
                'password' => bcrypt('abc123456'),
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
 /* alternando os usuarios do projetos */
 /* cadastra os dados ds coluna na tabela de usuaruis */
