<!-- resources/views/theme/show.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Get the Style file for the current theme from ThemeConfig --}}
    <?php
        $themeConfig = app(\App\Services\ThemeConfig::class);
        $styleFile = $themeConfig->getThemeCssFile();
    ?>

    {{-- Include the Style file dynamically --}}
    @include("{$styleFile}")

    <title>Show Theme</title>
</head>
<body>

    <p>Current Theme: {{ $theme }}</p>

    {{-- Your table styles and other content --}}
    <table>
        <tr>
            <th>Header 1</th>
            <th>Header 2</th>
            <th>Header 3</th>
        </tr>
        <tr>
            <td>Row 1, Cell 1</td>
            <td>Row 1, Cell 2</td>
            <td>Row 1, Cell 3</td>
        </tr>
        <tr>
            <td>Row 2, Cell 1</td>
            <td>Row 2, Cell 2</td>
            <td>Row 2, Cell 3</td>
        </tr>
        <tr>
            <td>Row 3, Cell 1</td>
            <td>Row 3, Cell 2</td>
            <td>Row 3, Cell 3</td>
        </tr>
    </table>

</body>
</html>
