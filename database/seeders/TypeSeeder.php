<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $type_labels = config('typeLabels');

    foreach ($type_labels as $label) {
      $type = new Type;
      $type->label = $label;
      $type->color = $faker->unique()->hexColor();
      $type->description = $faker->text(255);
      $type->save();
    }
  }
}
