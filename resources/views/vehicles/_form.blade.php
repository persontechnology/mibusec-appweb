
@php
  $isEdit = $vehicle && $vehicle->exists;
@endphp



<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="row">

      {{-- LICENSE PLATE --}}
      <div class="col-md-4">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-id-card"></i>
            </div>
            <input
              type="text"
              id="license_plate"
              name="license_plate"
              placeholder="Placa"
              value="{{ old('license_plate', $vehicle->license_plate) }}"
              class="form-control @error('license_plate') is-invalid @enderror"
              required
              autofocus
            >
            <label for="license_plate">Placa</label>
            @error('license_plate')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
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
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Nombre"
              value="{{ old('name', $vehicle->name) }}"
              class="form-control @error('name') is-invalid @enderror"
              required
            >
            <label for="name">Nombre</label>
            @error('name')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
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
            <textarea
              id="description"
              name="description"
              placeholder="Descripción"
              style="height: 120px"
              class="form-control @error('description') is-invalid @enderror"
            >{{ old('description', $vehicle->description) }}</textarea>
            <label for="description">Descripción</label>
            @error('description')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- CAPACITY --}}
      <div class="col-md-4">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-people-group"></i>
            </div>
            <input
              type="text"
              id="capacity"
              name="capacity"
              placeholder="Capacidad"
              value="{{ old('capacity', $vehicle->capacity) }}"
              class="form-control @error('capacity') is-invalid @enderror"
            >
            <label for="capacity">Capacidad</label>
            @error('capacity')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- STATUS --}}
      <div class="col-md-4">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-toggle-on"></i>
            </div>
            <select
              id="status"
              name="status"
              class="form-select @error('status') is-invalid @enderror"
            >
              <option value="" {{ old('status', $vehicle->status) === null ? 'selected' : '' }}>--</option>
              <option value="ACTIVE"   {{ old('status', $vehicle->status) === 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
              <option value="ANACTIVE" {{ old('status', $vehicle->status) === 'ANACTIVE' ? 'selected' : '' }}>ANACTIVE</option>
            </select>
            <label for="status">Estado</label>
            @error('status')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- NOTES --}}
      <div class="col-md-4">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-note-sticky"></i>
            </div>
            <input
              type="text"
              id="notes"
              name="notes"
              placeholder="Notas"
              value="{{ old('notes', $vehicle->notes) }}"
              class="form-control @error('notes') is-invalid @enderror"
            >
            <label for="notes">Notas</label>
            @error('notes')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- ACCIONES --}}
      <div class="col-12 d-flex justify-content-start gap-2">
        <a href="{{ route('vehicles.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-dark">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
      </div>
    </div>
  </div>
</div>
