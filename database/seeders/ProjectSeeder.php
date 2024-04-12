<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $type_ids = Type::all()->pluck('id');
    $user_ids = User::all()->pluck('id');
    for ($i = 0; $i < 150; $i++) {
      $project = new Project;
      $project->title = $faker->unique()->sentence(3);
      $project->slug = Str::of($project->title)->slug('-');
      $project->description = $faker->paragraph(5);
      $project->git_hub = $faker->unique()->url();
      // $project->image = $faker->imageUrl(640, 480, 'preview', true, $project->slug);
      $project->type_id = $faker->randomElement($type_ids);
      $project->user_id = $faker->randomElement($user_ids);
      // $project->author = User::find($project->user_id)->name;


      $project->save();
    }
  }
}
