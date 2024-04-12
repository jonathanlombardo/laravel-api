@extends('layouts.main')

@section('maincontent')
  <div class="container my-5">

    @include('layouts.partials.alert_message')

    <div class="d-flex align-items-center gap-3">
      <h1 class="m-0">{{ $project->title }}</h1>
      {!! $project->type->getBadge() !!}
    </div>
    <div class="row my-5">
      <div class="col-6 text-center d-flex flex-column gap-3">
        <div>
          <div><strong>Author</strong></div>
          <div>{{ $project->user->name }}</div>
        </div>
        <div>
          @if ($project->description)
            <div><strong>Description</strong></div>
            <div>{{ $project->description }}</div>
          @endif
        </div>
        <div>
          @if ($project->technologies->count())
            <div><strong>Technologies</strong></div>
            <div>{!! $project->getAllTechBadges() !!}</div>
          @endif
        </div>
        <a href="{{ $project->git_hub }}" class="btn btn-outline-primary {{ $project->git_hub ? '' : 'disabled' }}">Go to GitHub Repo</a>
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-outline-primary">Edit Project</a>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-destroy">Delete Project</button>
      </div>
      <div class="col-6 text-end">
        <img src="{{ $project->ImgUrl }}" alt="{{ $project->title }} image">
        <form action="{{ route('admin.projects.destroy-img', $project) }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn btn-link text-danger">Delete image</button>
        </form>
      </div>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-link">Back to Projects</a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-link">Back to Dashboard</a>

  </div>
@endsection

@section('modals')
  <!-- Modal -->
  <div class="modal fade" id="confirm-destroy" tabindex="-1" aria-labelledby="confirmDestroyModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting project</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          The elimination is permanent. Would you like to delete project {{ $project->title }}?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete project</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
