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
    $projects = Project::select('id', 'title', 'user_id', 'type_id', 'image', 'description', 'git_hub', 'updated_at')
      ->with('type:id,label,color', 'technologies:id,label,color')
      ->paginate();

    return response()->json($projects);
  }

  /**
   * Display the specified resource.
   *
   * @param  Project $project
   * @return \Illuminate\Http\Response
   */
  public function show(Project $project)
  {

    $project = [
      'id' => $project->id,
      'title' => $project->title,
      'author' => $project->author,
      'type' => $project->type,
      'technologies' => $project->technologies,
      'imgUrl' => $project->imgUrl,
      'description' => $project->description,
      'git_hub' => $project->git_hub,
      'updated_at' => $project->updated_at,
      'created_at' => $project->created_at,
    ];

    return response()->json($project);
  }
}
