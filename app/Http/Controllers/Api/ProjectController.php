<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $data = $request->all();

    $projects = Project::select('id', 'slug', 'title', 'user_id', 'type_id', 'image', 'description', 'git_hub', 'updated_at');

    if($data['searchTerm']){
      $projects->where('title', 'LIKE', '%' . $data['searchTerm'] . '%');          
    }
    
    if(isset($data['techs'])){
      foreach($data['techs'] as $tech){
        $projects->whereHas('technologies', function (Builder $query) use ($tech){
          $query->where('technologies.id', $tech);
        });
      }      
    }

    if(isset($data['types'])){
      foreach($data['types'] as $type){
        $projects->where('type_id', $type);
      }      
    }

    
    $projects->with('type:id,label,color', 'technologies:id,label,color');
    $projects = $projects->paginate(12);

    $success = true;

    $projects->makeHidden(['user', 'description', 'image']);
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

      $project->makeHidden(['user', 'abstract', 'image']);
      
      $success = true;

    return response()->json(['project' => $project, 'success' => $success]);
  }
}
