
@php $isEdit = $route && $route->exists; @endphp



<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="row">
      {{-- CODE --}}
      <div class="col-md-4">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-hashtag"></i>
            </div>
            <input type="text" id="code" name="code" placeholder="Código"
                   value="{{ old('code', $route->code) }}"
                   class="form-control @error('code') is-invalid @enderror" required>
            <label for="code">Código</label>
            @error('code')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      {{-- NAME --}}
      <div class="col-md-8">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-tag"></i>
            </div>
            <input type="text" id="name" name="name" placeholder="Nombre"
                   value="{{ old('name', $route->name) }}"
                   class="form-control @error('name') is-invalid @enderror">
            <label for="name">Nombre</label>
            @error('name')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      {{-- DESCRIPTION --}}
      <div class="col-12">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-align-left"></i>
            </div>
            <textarea id="description" name="description" placeholder="Descripción"
                      style="height: 120px"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $route->description) }}</textarea>
            <label for="description">Descripción</label>
            @error('description')<div class="invalid-feedback fw-bold">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      {{-- ACCIONES --}}
      <div class="col-12 d-flex justify-content-start gap-2">
        <a href="{{ route('routes.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-dark">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
      </div>
    </div>
  </div>
</div>
