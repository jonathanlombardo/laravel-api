@extends('layouts.main')

@section('assets')
  <style>
    .card img {
      height: 200px;
      width: 100%;
      object-fit: cover;
      object-position: center;
    }
  </style>
@endsection

@section('maincontent')
  <div class="container">
    <a class="btn btn-outline-primary w-100 my-3" data-bs-toggle="offcanvas" href="#filters" role="button" aria-controls="filters">
      Filter @if ($numFilter)
        ({{ $numFilter }})
      @endif
    </a>
    <h1 class="text-center ">HOME</h1>
    <div class="row g-3 py-5">
      @forelse ($projects as $project)
        <div class="col-4">
          <div class="card h-100">
            <img src="{{ $project->ImgUrl }}" class="card-img-top" alt="{{ $project->title }} image">
            <div class="card-body py-3 d-flex align-items-start flex-column">
              <h5 class="card-title">{{ $project->title }}</h5>
              {!! $project->type->getPublicBadge() !!}
              <p class="card-text py-3">{{ $project->abstract }}</p>
              <div class="align-self-end mt-auto">
                Author: {{ $project->user->name }}
              </div>
            </div>
            <div class="card-footer text-secondary fst-italic">
              {!! $project->getAllTechPublicBadges() !!}
              @unless ($project->getAllTechPublicBadges())
                <span>No specific technologies</span>
              @endunless
            </div>
          </div>
        </div>
      @empty
        <p class="text-center">No projects yet</p>
      @endforelse
      {{ $projects->links() }}
    </div>
  </div>
@endsection

@section('modals')
  <div class="offcanvas offcanvas-start" tabindex="-1" id="filters" aria-labelledby="filtersLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="filtersLabel">Offcanvas</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form method="GET" class="offcanvas-body">
      <div class="fw-bold">
        Choose the filters and press "Filter" button
      </div>
      @if ($users)
        <div class="mt-4 mb-2">Author</div>
        @foreach ($users as $user)
          <div class="mb-2">
            <input {{ in_array($user->id, request('filter_users', [])) ? 'checked' : '' }} type="checkbox" class="form-check-input" name="filter_users[]" id="filter-users-{{ $user->id }}" value="{{ $user->id }}">
            <label for="filter-users-{{ $user->id }}">{{ $user->name }}</label>
          </div>
        @endforeach
      @endif
      @if ($types)
        <div class="mt-4 mb-2">Type</div>
        @foreach ($types as $type)
          <div class="mb-2">
            <input {{ in_array($type->id, request('filter_types', [])) ? 'checked' : '' }} type="checkbox" class="form-check-input" name="filter_types[]" id="filter-types-{{ $type->id }}" value="{{ $type->id }}">
            <label for="filter-types-{{ $type->id }}">{{ $type->label }}</label>
          </div>
        @endforeach
      @endif
      @if ($techs)
        <div class="mt-4 mb-2">Technologies</div>
        @foreach ($techs as $tech)
          <div class="mb-2">
            <input {{ in_array($tech->id, request('filter_technologies', [])) ? 'checked' : '' }} type="checkbox" class="form-check-input" name="filter_technologies[]" id="filter-technologies-{{ $tech->id }}" value="{{ $tech->id }}">
            <label for="filter-technologies-{{ $tech->id }}">{{ $tech->label }}</label>
          </div>
        @endforeach
      @endif

      <button class="btn btn-success w-100 mt-3">Filter</button>
      <a href="{{ route('guest.index') }}" class="btn btn-outline-secondary w-100 mt-3">Reset Filter</a>

    </form>
  </div>
@endsection
