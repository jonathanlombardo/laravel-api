<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $projects = Project::select('id', 'slug', 'title', 'user_id', 'type_id', 'image', 'description', 'git_hub', 'updated_at')
      ->with('type:id,label,color', 'technologies:id,label,color')
      ->paginate(12);

    $success = true;

    return response()->json(['projects' => $projects, 'success' => $success]);
  }

  /**
   * Display the specified resource.
   *
   * @param  String $slug
   * @return \Illuminate\Http\Response
   */
  public function show(String $slug)
  {
    $project = Project::select('id', 'slug', 'title', 'user_id', 'type_id', 'image', 'description', 'git_hub', 'updated_at')
      ->where('slug', $slug)
      ->with('type:id,label,color', 'technologies:id,label,color')
      ->first();
    
    if(!$project){
      $success = false;
      return response()->json(['project' => $project, 'success' => $success]);
    }

      $project->makeHidden('user');
      $project->makeHidden('abstract');
      
      $success = true;

    return response()->json(['project' => $project, 'success' => $success]);
  }
}
