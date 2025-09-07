@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('route.stops.create', $route) }}
@endsection

@section('content')


  @php
      // Mezcla OLD (si viene tras validación) con los seleccionados actuales
      $oldStops = old('stops', $selectedStopIds ?? []);
      // Normaliza a strings para comparar de forma estricta
      $oldStops = is_array($oldStops) ? array_map('strval', $oldStops) : [];
  @endphp

  <form method="POST" action="{{ route('route.stops.store', $route) }}" class="form_global">
    @csrf

    <div class="card">
      <div class="card-body">
        <label for="stops" class="form-label">Paradas</label>
        <select
          multiple
          id="stops"
          name="stops[]"
          class="form-control listbox-sorting {{ $errors->has('stops') || $errors->has('stops.*') ? 'is-invalid' : '' }}"
          required
        >
          @foreach($allStops as $stop)
            <option
              value="{{ $stop->id }}"
              {{ in_array((string) $stop->id, $oldStops, true) ? 'selected' : '' }}
            >
              {{ $stop->code }} - {{ $stop->name }}
            </option>
          @endforeach
        </select>

        {{-- Errores específicos del campo --}}
        @error('stops')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        {{-- Si hay errores en stops.* (por ejemplo, exists/distinct), muéstralos también --}}
        @if($errors->has('stops.*'))
          @foreach($errors->get('stops.*') as $messages)
            @foreach($messages as $msg)
              <div class="invalid-feedback d-block">{{ $msg }}</div>
            @endforeach
          @endforeach
        @endif

      </div>
    </div>

    <div class="text-start mt-3">
      <a href="{{ route('route.stops.index', $route) }}" class="btn btn-danger">Cancelar</a>
      <button type="submit" class="btn btn-dark">Guardar</button>
    </div>
  </form>
@endsection

@prepend('scripts')
  <script src="{{ asset('assets/js/vendor/forms/inputs/dual_listbox.min.js') }}"></script>
@endprepend

@push('scripts')
  <script>
    // IMPORTANTE: el plugin lee los <option selected> al inicializarse.
    // Como ya marcamos selected en Blade con old(), esto conserva el estado.
    const listboxSortingElement = document.querySelector(".listbox-sorting");
    const listboxSorting = new DualListbox(listboxSortingElement, {
      sortable: true,
      upButtonText: "<i class='ph-caret-up'></i>",
      downButtonText: "<i class='ph-caret-down'></i>",
      addButtonText: "<i class='ph-caret-right'></i>",
      removeButtonText: "<i class='ph-caret-left'></i>",
      addAllButtonText: "<i class='ph-caret-double-right'></i>",
      removeAllButtonText: "<i class='ph-caret-double-left'></i>",
      availableTitle: "Paradas disponibles",
      selectedTitle: "Paradas asignadas a la ruta",
      searchPlaceholder: "Buscar por código o nombre...",
    });
  </script>
@endpush
