@props(['name'])

@error($name)
<p class="w3-text-red w3-small" style="font-weight:600; margin-top:8px;">{{ $message }}</p>
@enderror
