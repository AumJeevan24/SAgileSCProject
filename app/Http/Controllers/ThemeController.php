<?php

// app/Http/Controllers/ThemeController.php

namespace App\Http\Controllers;

use App\Services\ThemeConfig;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function chooseTheme(ThemeConfig $themeConfig)
    {
        $availableThemes = ['theme1', 'theme2', 'theme3'];
        return view('theme.choose', ['themes' => $availableThemes, 'currentTheme' => $themeConfig->getTheme()]);
    }

    public function setTheme(ThemeConfig $themeConfig, Request $request)
    {
        $selectedTheme = $request->input('theme');
        $themeConfig->setTheme($selectedTheme);
        return redirect()->route('show-theme');
    }

    public function showTheme(ThemeConfig $themeConfig)
    {
        $theme = $themeConfig->getTheme();
        $styleFile = $themeConfig->getThemeCssFile();
        return view('theme.show', ['theme' => $theme, 'styleFile' => $styleFile]);
    }
}

