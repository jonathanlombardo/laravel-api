<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
  // use HasFactory;

  protected $fillable = ['label', 'color', 'description'];

  public function projects()
  {
    return $this->hasMany(Project::class);
  }

  public function getBadge()
  {
    $route = route('admin.types.show', $this);
    return "<a href='$route' class='badge type' style='background-color: $this->color'>$this->label</a>";
  }

  public function getPublicBadge()
  {
    $route = route('guest.index', ['filter_types' => [$this->id]]);
    return "<a href='$route' class='badge type' style='background-color: $this->color'>$this->label</a>";
  }
}
