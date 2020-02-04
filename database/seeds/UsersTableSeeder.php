<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'full_name' => 'Nguyễn Đức Chung',
                'avatar' => 'avatar-default.jpg',
                'email' => 'chungnd10@gmail.com',
                'password' => bcrypt(12345678),
                'phone_number' => '0363223618',
                'birthday' => '1996-10-31',
                'address' => 'Dịch Vọng, Cầu Giấy, Hà Nội',
                'role_id' => 1
            ],
            [
                'full_name' => 'Nguyễn Văn A',
                'avatar' => 'avatar-default.jpg',
                'email' => 'phucvu@localhost.com',
                'password' => bcrypt(12345678),
                'phone_number' => '0363223617',
                'birthday' => '1996-10-31',
                'address' => 'Dịch Vọng, Cầu Giấy, Hà Nội',
                'role_id' => 2
            ],
            [
                'full_name' => 'Nguyễn Văn B',
                'avatar' => 'avatar-default.jpg',
                'email' => 'phache@localhost.com',
                'password' => bcrypt(12345678),
                'phone_number' => '0363223616',
                'birthday' => '1996-10-31',
                'address' => 'Dịch Vọng, Cầu Giấy, Hà Nội',
                'role_id' => 3
            ],
            [
                'full_name' => 'Nguyễn Văn C',
                'avatar' => 'avatar-default.jpg',
                'email' => 'thungan@localhost.com',
                'password' => bcrypt(12345678),
                'phone_number' => '0363223615',
                'birthday' => '1996-10-31',
                'address' => 'Dịch Vọng, Cầu Giấy, Hà Nội',
                'role_id' => 4
            ]
        ];
        DB::table('users')->insert($status);
    }
}
