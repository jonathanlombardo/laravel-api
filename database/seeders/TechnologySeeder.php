<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TechnologySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $technology_labels = config('technologyLabels');

    foreach ($technology_labels as $label) {
      $type = new Technology;
      $type->label = $label;
      $type->color = $faker->unique()->hexColor();
      $type->description = $faker->text(255);
      $type->save();
    }
  }
}
