<?php

// app/Http/Controllers/ThemeController.php

namespace App\Http\Controllers;

use App\Services\ThemeConfig;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function setTheme(ThemeConfig $themeConfig, Request $request)
    {
        $selectedTheme = $request->input('theme');
        $themeConfig->setTheme($selectedTheme);
        return redirect()->route('show-theme');
    }
}

