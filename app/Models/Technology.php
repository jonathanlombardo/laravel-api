<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
  use HasFactory;

  protected $fillable = ['label', 'color', 'description'];

  public function projects()
  {
    return $this->belongsToMany(Project::class);
  }

  public function getBadge()
  {
    $route = route('admin.technologies.show', $this);
    return "<a href='$route' style='color: $this->color; font-weight: bold;'>$this->label</a>";
  }

  public function getPublicBadge()
  {
    $route = $route = route('guest.index', ['filter_technologies' => [$this->id]]);
    return "<a href='$route' style='color: $this->color; font-weight: bold;'>$this->label</a>";
  }
}
