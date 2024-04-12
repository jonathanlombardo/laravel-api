<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectFormRequest;
use App\Models\Project;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    $types_count = Type::all()->count();

    $projects = Project::select();
    if (Auth::user()->role != 'admin')
      $projects->whereBelongsTo(Auth::user());
    $projects = $projects->orderBy('id', 'desc')->paginate(15);
    return view('admin.projects.index', compact('projects', 'types_count'));
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    $types = Type::all();
    $technologies = Technology::all();

    $editForm = false;
    $project = new Project;
    if ($types->count())
      return view('admin.projects.form', compact('editForm', 'types', 'technologies', 'project'));
    return redirect()->route('admin.projects.index')->with('messageClass', 'alert-warning')->with('message', 'No available type. Please create a new Project Type before.');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(ProjectFormRequest $request)
  {
    $request->validated();

    // dd($request->all());

    $datas = $request->all();
    $project = new Project;
    $project->fill($datas);
    $project->slug = Str::of($project->title)->slug('-');
    $project->user_id = Auth::id();


    if (isset($datas['image'])) {
      $img_path = Storage::put('uploads/projects', $datas['image']);
      $project->image = $img_path;
    }

    $project->save();

    if (isset($request['techs']))
      $project->technologies()->sync($request['techs']);

    return redirect()->route('admin.projects.show', $project)->with('messageClass', 'alert-success')->with('message', 'Project Saved');

  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Project  $project
   */
  public function show(Project $project)
  {
    if ($project->user_id != Auth::id() && Auth::user()->role != 'admin')
      abort(403);
    return view('admin.projects.show', compact('project'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Project  $project
   */
  public function edit(Project $project)
  {
    if ($project->user_id != Auth::id() && Auth::user()->role != 'admin')
      abort(403);

    $types = Type::all();
    $technologies = Technology::all();
    $projTechIds = $project->technologies->pluck('id')->toArray();

    $editForm = true;
    return view('admin.projects.form', compact('project', 'editForm', 'types', 'technologies', 'projTechIds'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Project  $project
   */
  public function update(ProjectFormRequest $request, Project $project)
  {
    // dump($request->all());
    // exit;

    if ($project->user_id != Auth::id() && Auth::user()->role != 'admin')
      abort(403);


    $request->validated();

    $datas = $request->all();
    $project->fill($datas);
    $project->slug = Str::of($project->title)->slug('-');

    if (isset($datas['image'])) {
      if ($project->image)
        Storage::delete($project->image);
      $img_path = Storage::put('uploads/projects', $datas['image']);
      $project->image = $img_path;
    }

    $project->save();

    if (isset($request['techs'])) {
      $project->technologies()->sync($request['techs']);
    } else {
      $project->technologies()->detach();
    }


    return redirect()->route('admin.projects.show', $project)->with('messageClass', 'alert-success')->with('message', 'Project Updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Project  $project
   */
  public function destroy(Project $project)
  {
    if ($project->user_id != Auth::id() && Auth::user()->role != 'admin')
      abort(403);

    Storage::delete($project->image);
    $project->delete();
    return redirect()->route('admin.projects.index')->with('messageClass', 'alert-success')->with('message', 'Project deleted');
  }

  public function destroyImg(Project $project)
  {
    if ($project->user_id != Auth::id() && Auth::user()->role != 'admin')
      abort(403);

    Storage::delete($project->image);
    $project->image = null;
    $project->save();
    return redirect()->back();
  }
}
