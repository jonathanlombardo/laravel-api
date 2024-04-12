<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;

class GuestController extends Controller
{
  public function index(Request $request)
  {
    $users = User::all();
    $types = Type::all();
    $techs = Technology::all();

    $numFilter = count($request->all());

    $filter_users = $request->input('filter_users') ?? null;
    $filter_types = $request->input('filter_types') ?? null;
    $filter_technologies = $request->input('filter_technologies') ?? null;

    $projects = Project::select('projects.*')
      ->join('project_technology', 'projects.id', '=', 'project_technology.project_id')
      ->join('technologies', 'technologies.id', '=', 'project_technology.technology_id');

    if ($filter_technologies)
      $projects->whereIn('technologies.id', $filter_technologies);

    if ($filter_users)
      $projects->whereIn('user_id', $filter_users);

    if ($filter_types)
      $projects->whereIn('type_id', $filter_types);


    $projects = $projects->orderBy('id', 'desc')->distinct('projects.id')->paginate(12);
    return view('guest.index', compact('projects', 'users', 'types', 'techs', 'numFilter'));

  }

  public function filterIndex(Request $request)
  {

  }
}
