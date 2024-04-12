<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TypeDeleteRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypeFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   */
  public function index()
  {
    $types = Type::orderBy('id', 'desc')->paginate(15);
    return view('admin.types.index', compact('types'));
  }

  /**
   * Show the form for creating a new resource.
   *
   */
  public function create()
  {
    $editForm = false;
    return view('admin.types.form', compact('editForm'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(TypeFormRequest $request)
  {
    $request->validated();

    $datas = $request->all();
    $type = new Type;
    $type->fill($datas);
    $type->save();

    return redirect()->route('admin.types.show', $type)->with('messageClass', 'alert-success')->with('message', 'Type Saved');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Type  $type
   */
  public function show(Type $type)
  {
    $related_projects = $type->projects()->select();
    if (Auth::user()->role != 'admin')
      $related_projects->whereBelongsTo(Auth::user());
    $related_projects = $related_projects->paginate(10);
    return view('admin.types.show', compact('type', 'related_projects'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Type  $type
   */
  public function edit(Type $type)
  {
    $editForm = true;
    return view('admin.types.form', compact('type', 'editForm'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Type  $type
   */
  public function update(TypeFormRequest $request, Type $type)
  {
    $request->validated();

    $datas = $request->all();
    $type->fill($datas);
    $type->save();

    return redirect()->route('admin.types.show', $type)->with('messageClass', 'alert-success')->with('message', 'Type Saved');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Type  $type
   */
  public function destroy(TypeDeleteRequest $request, Type $type)
  {
    $request->validated();

    $newId = $request->input('action_on_project');

    foreach ($type->projects as $project) {
      if ($newId == $type->id) {
        $project->delete();
      } else {
        $project->type_id = $newId;
        $project->save();
      }
    }

    $type->delete();
    return redirect()->route('admin.types.index')->with('messageClass', 'alert-success')->with('message', 'Type deleted');
  }
}
