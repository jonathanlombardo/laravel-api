@extends('layouts.main')

@section('maincontent')
  <div class="container my-5">
    <h1>{{ $editForm ? 'Edit Technologies' : 'Create Technologies' }}</h1>

    @if ($errors->any())
      <div class="error-alert alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Check and correct fields on error!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ $editForm ? route('admin.technologies.update', $technology) : route('admin.technologies.store') }}" method="POST" class="row my-4 g-3">
      @csrf
      @method($editForm ? 'PATCH' : 'POST')

      <div class="col-11">
        <div class="form-floating">
          <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" placeholder="label" value="{{ $editForm ? ($errors->any() ? old('label') : $technology->label) : old('label') }}">
          <label for="label">Technology label</label>
          @error('label')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-1">
        <div class="form-floating">
          <input type="color" class="form-control @error('color') is-invalid @enderror" id="color" name="color" placeholder="color" value="{{ $editForm ? ($errors->any() ? old('color') : $technology->color) : old('color') }}">
          <label for="color">Technology color</label>
          @error('color')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control @error('description') is-invalid @enderror" placeholder="description" id="description" name="description" style="height: 100px">{{ $editForm ? ($errors->any() ? old('description') : $technology->description) : old('description') }}</textarea>
          <label for="description">Technology Description</label>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <button class="btn btn-success">{{ $editForm ? 'Edit technology' : 'Save' }}</button>
        <a href="{{ route('admin.technologies.index') }}" class="btn btn-warning">Back to technologies list</a>
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
        errorAlertEl.classList.add('d-none')
      })
    });

    textareas.forEach((textarea) => {
      textarea.addEventListener("change", function() {
        this.classList.remove('is-invalid')
        errorAlertEl.classList.add('d-none')
      })
    });

    selects.forEach((select) => {
      select.addEventListener("change", function() {
        this.classList.remove('is-invalid')
        errorAlertEl.classList.add('d-none')
      })
    });
  </script>
@endsection
