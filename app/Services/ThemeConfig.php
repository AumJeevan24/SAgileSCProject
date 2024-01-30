<?php

// app/Services/ThemeConfig.php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class ThemeConfig
{
    protected $sessionKey = 'chosen_theme';

    public function setTheme($theme)
    {
        Session::put($this->sessionKey, $theme);
    }

    public function getTheme()
    {
        return Session::get($this->sessionKey, 'theme2'); // 'default' is a fallback theme if none is set
    }

    public function getThemeCssFile()
    {
        $theme = $this->getTheme();

        // Use a naming convention for style files (e.g., 'style_theme1', 'style_theme2')
        return "inc.style_{$theme}";
    }
}
