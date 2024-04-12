@extends('layouts.main')

@section('assets')
  <style>
    .proj-img {
      width: 100%;
      height: 270px;
      object-fit: cover;
      object-position: top;
    }
  </style>
@endsection

@section('maincontent')
  <div class="container my-5">
    <h1>{{ $project->id ? 'Edit project' : 'Create Project' }}</h1>

    @if ($errors->any())
      <div class="error-alert alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Check and correct fields on error!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif



    <form enctype="multipart/form-data" action="{{ $project->id ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" class="row my-4 g-3">
      @csrf
      @method($project->id ? 'PATCH' : 'POST')

      <div class="col-6">
        <div class="form-floating">
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="title" value="{{ $project->id ? ($errors->any() ? old('title') : $project->title) : old('title') }}">
          <label for="title">Project Title</label>
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-6">
        <div class="form-floating">

          <div class="form-floating">
            <select class="form-select @error('type_id') is-invalid @enderror" id="type_id" name="type_id" aria-label="Type select">
              <option value="" class="d-none">Select a project type</option>
              @foreach ($types as $type)
                <option value="{{ $type->id }}" {{ $type->id == old('type_id', $project->id ? $project->type->id : '') ? 'selected' : '' }}>
                  {{ $type->label }}
                </option>
              @endforeach
            </select>
            <label for="type_id">Type</label>
            @error('type_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      <div class="col-12">
        <hr>
        <div class="row g-3">
          @foreach ($technologies as $techology)
            <div class="col-2 @error('techs') is-invalid @enderror">
              <input {{ in_array($techology->id, old('techs', $project->id ? $projTechIds : [])) ? 'checked' : '' }} id="tech-{{ $techology->id }}" name="techs[]" value="{{ $techology->id }}" type="checkbox" class="form-check-input @error('techs') is-invalid @enderror">
              <label class="form-check-label" for="tech-{{ $techology->id }}">{{ $techology->label }}</label>
            </div>
          @endforeach
          @error('techs')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <hr>

      </div>
      <div class="col-12">
        <div class="form-floating">
          <input type="url" class="form-control @error('git_hub') is-invalid @enderror" id="git_hub" name="git_hub" placeholder="git_hub" value="{{ $project->id ? ($errors->any() ? old('git_hub') : $project->git_hub) : old('git_hub') }}">
          <label for="git_hub">GitHub Repo URL</label>
          @error('git_hub')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-8">
        <div class="form-floating">
          <input type="file" class="proj-img-input form-control @error('image') is-invalid @enderror" id="image" name="image" placeholder="image" value="{{ $project->id ? ($errors->any() ? old('image') : $project->image) : old('image') }}">
          <label for="image">Image</label>
          <div class="invalid-feedback img-fb">
            @error('image')
              {{ $message }}
            @enderror
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="text-end">
          <img src="{{ $project->getImgUrl() }}" alt="" class="proj-img">
          <button class="reset-img btn btn-link" type="button">Reset uploaded image</button>
        </div>
      </div>

      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control @error('description') is-invalid @enderror" placeholder="description" id="description" name="description" style="height: 100px">{{ $project->id ? ($errors->any() ? old('description') : $project->description) : old('description') }}</textarea>
          <label for="description">Project Description</label>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <button class="btn btn-success">{{ $project->id ? 'Edit project' : 'Save' }}</button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-warning">Back to projects list</a>
      </div>


    </form>
  </div>
@endsection

@section('script')
  <script>
    const inputs = document.querySelectorAll('input');
    const textareas = document.querySelectorAll('textarea');
    const selects = document.querySelectorAll('select');
    const errorAlertEl = document.querySelector('.error-alert');

    inputs.forEach((input) => {
      input.addEventListener("input", function() {
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })

      input.addEventListener("change", function() {
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })
    });

    textareas.forEach((textarea) => {
      textarea.addEventListener("change", function() {
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })
    });

    selects.forEach((select) => {
      select.addEventListener("change", function() {
        this.classList.remove('is-invalid')
        if (errorAlertEl) errorAlertEl.classList.add('d-none')
      })
    });

    const projImg = document.querySelector('.proj-img');
    const projImgInput = document.querySelector('.proj-img-input');
    const fbImgEl = document.querySelector('.img-fb');
    const resetImgBtn = document.querySelector('.reset-img');
    const originalSrc = projImg.src;

    projImgInput.addEventListener("change", function() {
      const file = this.files[0];

      if (file.type.startsWith('image')) {
        const reader = new FileReader();
        console.log(this.files[0].type);
        reader.onloadend = function() {
          projImg.src = reader.result;
        }
        if (file) {
          reader.readAsDataURL(file);
        } else {
          projImg.src = originalSrc;
        }
      } else {
        projImg.src = originalSrc
        projImgInput.value = null;
        projImgInput.classList.add('is-invalid')
        fbImgEl.innerText = 'The image must be an image'
      }

    })

    resetImgBtn.addEventListener('click', function() {
      projImg.src = originalSrc
      projImgInput.value = null;
      projImgInput.classList.remove('is-invalid')
    })
  </script>
@endsection
