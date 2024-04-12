<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = new User;
    $user->name = 'admin';
    $user->role = 'admin';
    $user->email = 'admin@admin.com';
    $user->password = Hash::make('password');
    $user->save();

    $user = new User;
    $user->name = 'user';
    $user->email = 'user@user.com';
    $user->password = Hash::make('password');
    $user->save();
  }
}
