<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
           value="{{ old('nom', $item->nom ?? '') }}" required>
    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">URL</label>
    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
           value="{{ old('url', $item->url ?? '') }}" required>
    @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Icône (ex: fa-brands fa-facebook)</label>
    <input type="text" name="icone" class="form-control @error('icone') is-invalid @enderror"
           value="{{ old('icone', $item->icone ?? '') }}">
    @error('icone') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="actif" id="actif" class="form-check-input" value="1"
           {{ old('actif', $item->actif ?? false) ? 'checked' : '' }}>
    <label for="actif" class="form-check-label">Actif</label>
</div>
