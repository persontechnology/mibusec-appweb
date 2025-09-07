{{-- resources/views/stops/_form.blade.php --}}
@php
  $isEdit = $stop && $stop->exists;
  $lat = old('latitude', $stop->latitude ?? null);
  $lng = old('longitude', $stop->longitude ?? null);
@endphp



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
            <input
              type="text"
              id="code"
              name="code"
              placeholder="Code"
              value="{{ old('code', $stop->code) }}"
              class="form-control @error('code') is-invalid @enderror"
              required
              autofocus
            >
            <label for="code">Code</label>
            @error('code')
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
              placeholder="Name"
              value="{{ old('name', $stop->name) }}"
              class="form-control @error('name') is-invalid @enderror"
              required
            >
            <label for="name">Name</label>
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
              placeholder="Description"
              style="height: 120px"
              class="form-control @error('description') is-invalid @enderror"
            >{{ old('description', $stop->description) }}</textarea>
            <label for="description">Description</label>
            @error('description')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- ADDRESS --}}
      <div class="col-md-8">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <input
              type="text"
              id="address"
              name="address"
              placeholder="Address"
              value="{{ old('address', $stop->address) }}"
              class="form-control @error('address') is-invalid @enderror"
            >
            <label for="address">Address</label>
            @error('address')
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
              <option value="" {{ old('status', $stop->status) === null ? 'selected' : '' }}>--</option>
              <option value="ACTIVE"   {{ old('status', $stop->status) === 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
              <option value="ANACTIVE" {{ old('status', $stop->status) === 'ANACTIVE' ? 'selected' : '' }}>ANACTIVE</option>
            </select>
            <label for="status">Status</label>
            @error('status')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- LATITUDE --}}
      <div class="col-md-6">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-compass"></i>
            </div>
            <input
              type="text"
              id="latitude"
              name="latitude"
              placeholder="Latitude"
              value="{{ $lat }}"
              class="form-control @error('latitude') is-invalid @enderror"
              readonly
              required
            >
            <label for="latitude">Latitude</label>
            @error('latitude')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- LONGITUDE --}}
      <div class="col-md-6">
        <div class="mb-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-location-crosshairs"></i>
            </div>
            <input
              type="text"
              id="longitude"
              name="longitude"
              placeholder="Longitude"
              value="{{ $lng }}"
              class="form-control @error('longitude') is-invalid @enderror"
              readonly
              required
            >
            <label for="longitude">Longitude</label>
            @error('longitude')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- MAPA + GEOLOCATE --}}
      <div class="col-12">
        <div class="mb-2 d-flex gap-2 align-items-center alert alert-info">
          <button class="btn btn-info btn-sm" type="button" id="btn-geolocate">Usar mi ubicación</button>
          <small class="text-muted">O haz clic en el mapa para colocar el marcador.</small>
        </div>
        <div id="map" style="height: 360px; border-radius: .5rem; overflow: hidden;"></div>
      </div>

      {{-- NOTES --}}
      <div class="col-12">
        <div class="my-3">
          <div class="form-floating form-control-feedback form-control-feedback-start">
            <div class="form-control-feedback-icon">
              <i class="fa-solid fa-note-sticky"></i>
            </div>
            <textarea
              id="notes"
              name="notes"
              placeholder="Notes"
              style="height: 120px"
              class="form-control @error('notes') is-invalid @enderror"
            >{{ old('notes', $stop->notes) }}</textarea>
            <label for="notes">Notes</label>
            @error('notes')
              <div class="invalid-feedback fw-bold">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- ACCIONES --}}
      <div class="col-12 d-flex justify-content-start gap-2">
        <a href="{{ route('stops.index') }}" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-dark">{{ $isEdit ? 'Actualizar' : 'Guardar' }}</button>
      </div>
    </div>
  </div>
</div>

@prepend('scripts')
  <script src="{{ asset('assets/js/vendor/maps/leaflet/leaflet.min.js') }}"></script>
@endprepend

@push('scripts')

  <script>
    (function () {
      const latInput = document.getElementById('latitude');
      const lngInput = document.getElementById('longitude');
      const geolocateBtn = document.getElementById('btn-geolocate');

      const initialLat = parseFloat(latInput.value);
      const initialLng = parseFloat(lngInput.value);
      const hasInitial = !isNaN(initialLat) && !isNaN(initialLng);

      const map = L.map('map');
      const defaultCenter = hasInitial ? [initialLat, initialLng] : [0, 0];
      const defaultZoom   = hasInitial ? 15 : 2;

      map.setView(defaultCenter, defaultZoom);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
      }).addTo(map);

      let marker = null;

      function placeMarker(lat, lng) {
        if (marker) {
          marker.setLatLng([lat, lng]);
        } else {
          marker = L.marker([lat, lng], { draggable: true }).addTo(map);
          marker.on('dragend', e => {
            const { lat, lng } = e.target.getLatLng();
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
          });
        }
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
      }

      if (hasInitial) {
        placeMarker(initialLat, initialLng);
      }

      map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        placeMarker(lat, lng);
      });

      geolocateBtn?.addEventListener('click', () => {
        if (!navigator.geolocation) {
          alert('Geolocalización no soportada por tu navegador.');
          return;
        }
        navigator.geolocation.getCurrentPosition(
          pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            map.setView([lat, lng], 16);
            placeMarker(lat, lng);
          },
          err => {
            alert('No se pudo obtener tu ubicación.');
          },
          { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
      });
    })();
  </script>
@endpush
