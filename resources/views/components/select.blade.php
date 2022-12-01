<div>
    <div class="form-group">
        <select {{ $multi ? 'multiple' : '' }} name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">
            <option value="" disabled selected>Selcet One</option>
            {{ $slot }}
        </select>
        @error($name)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>