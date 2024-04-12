<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;

class Project extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'type_id',
    'description',
    'git_hub',
  ];

  protected $appends = ['imgUrl', 'abstract', 'author'];

  public function type()
  {
    return $this->belongsTo(Type::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function technologies()
  {
    return $this->belongsToMany(Technology::class);
  }

  public function getAllTechBadges()
  {
    $badges = [];
    foreach ($this->technologies as $technology) {
      $badges[] = $technology->getBadge();
    }

    return implode(' - ', $badges);
  }

  public function getAllTechPublicBadges()
  {
    $badges = [];
    foreach ($this->technologies as $technology) {
      $badges[] = $technology->getPublicBadge();
    }

    return implode(' - ', $badges);
  }

  public function getAbstract($n)
  {
    // return $this->description;

    $desc = $this->description;
    return strlen($desc) > ($n + 3) ? substr($desc, 0, $n) . '...' : $desc;
  }

  public function getImgUrlAttribute()
  {
    if ($this->image) {
      return asset("/storage/$this->image");
    } else {
      return asset("/img/projects/placeholder.jpg");
    }
  }
  public function getAbstractAttribute()
  {
    return $this->getAbstract(40);
  }

  public function getAuthorAttribute()
  {
    return $this->user->name;
  }
}
