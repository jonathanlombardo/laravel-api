@extends('layouts.main')

@section('assets')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('maincontent')
  <div class="container my-5">
    @include('layouts.partials.alert_message')
    @if ($errors->any())
      <div class="error-alert alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
          <strong>{{ $error }}</strong><br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if (Auth::User()->role == 'admin')
      <a href="{{ route('admin.types.create') }}" class="btn btn-outline-primary mb-3"><i class="fa-solid fa-plus"></i> New Type</a>
      <a href="{{ route('admin.technologies.create') }}" class="btn btn-outline-primary mb-3"><i class="fa-solid fa-plus"></i> New Technologies</a>
    @endif
    <a href="{{ route('admin.projects.create') }}" class="btn btn-outline-primary mb-3"><i class="fa-solid fa-plus"></i> New project</a>
    <table class="table text-center mb-5">
      <thead>
        <tr>
          <th>Label</th>
          <th>Color</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($types as $type)
          <tr>
            <td>{{ $type->label }}</td>
            <td class="fs-4"><i class="fa-solid fa-circle" style="color: {{ $type->color }}"></i></td>
            <td class="fs-4">
              <a class="me-2" href="{{ route('admin.types.show', $type) }}"><i class="fa-solid fa-eye"></i></a>
              @if (Auth::User()->role == 'admin')
                <a class="me-2" href="{{ route('admin.types.edit', $type) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="me-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('destroy-btn-{{ $type->id }}').click();"><i class="fa-solid fa-trash"></i></a>
                <button id="destroy-btn-{{ $type->id }}" type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#confirm-destroy-{{ $type->id }}"></button>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="100%">No Types yet</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    {{ $types->links() }}
  </div>
@endsection

@section('modals')
  @foreach ($types as $type)
    <!-- Modal -->
    <div class="modal fade" id="confirm-destroy-{{ $type->id }}" tabindex="-1" aria-labelledby="confirmDestroyModal" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{ route('admin.types.destroy', $type) }}" method="POST" class="modal-content">
          @csrf
          @method('DELETE')

          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting type</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            The elimination is permanent. Would you like to delete type {{ $type->title }}?
            <br>
            <span class="text-danger fw-bold">Warning</span>
            <span class="fw-bold">: Choose an option for projects assigned to {{ $type->title }}</span>
            <div class="form-floating mt-3">
              <select class="form-select @error('action_on_project') is-invalid @enderror" id="action_on_project" name="action_on_project" aria-label="Action select">
                <option value="" class="d-none">Select an option</option>
                <option value="{{ $type->id }}">Delete projects</option>
                @foreach ($types as $typeToAssign)
                  @if ($typeToAssign->id != $type->id)
                    <option value="{{ $typeToAssign->id }}">
                      Assign to "{{ $typeToAssign->label }}"
                    </option>
                  @endif
                @endforeach
              </select>
              <label for="action_on_project">Action</label>
              @error('action_on_project')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-danger">Delete type</button>
          </div>
        </form>
      </div>
    </div>
  @endforeach
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
