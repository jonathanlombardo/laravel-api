@extends('layouts.main')

@section('maincontent')
  <div class="container my-5">
    <h1>{{ $editForm ? 'Edit Type' : 'Create Type' }}</h1>

    @if ($errors->any())
      <div class="error-alert alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Check and correct fields on error!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ $editForm ? route('admin.types.update', $type) : route('admin.types.store') }}" method="POST" class="row my-4 g-3">
      @csrf
      @method($editForm ? 'PATCH' : 'POST')

      <div class="col-11">
        <div class="form-floating">
          <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" placeholder="label" value="{{ $editForm ? ($errors->any() ? old('label') : $type->label) : old('label') }}">
          <label for="label">Type label</label>
          @error('label')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-1">
        <div class="form-floating">
          <input type="color" class="form-control @error('color') is-invalid @enderror" id="color" name="color" placeholder="color" value="{{ $editForm ? ($errors->any() ? old('color') : $type->color) : old('color') }}">
          <label for="color">Type color</label>
          @error('color')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control @error('description') is-invalid @enderror" placeholder="description" id="description" name="description" style="height: 100px">{{ $editForm ? ($errors->any() ? old('description') : $type->description) : old('description') }}</textarea>
          <label for="description">Type Description</label>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="col-12">
        <button class="btn btn-success">{{ $editForm ? 'Edit type' : 'Save' }}</button>
        <a href="{{ route('admin.types.index') }}" class="btn btn-warning">Back to types list</a>
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
