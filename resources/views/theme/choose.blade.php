<!-- resources/views/theme/choose.blade.php -->

<form method="get" action="{{ route('set-theme', ['theme' => $currentTheme]) }}">
    @csrf
    <label for="theme">Choose Theme:</label>
    <select name="theme" id="theme">
        @foreach ($themes as $themeOption)
            <option value="{{ $themeOption }}" {{ $themeOption == $currentTheme ? 'selected' : '' }}>
                {{ ucfirst($themeOption) }}
            </option>
        @endforeach
    </select>
    <button type="submit">Set Theme</button>
</form>
