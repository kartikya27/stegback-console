<?php

namespace Kartikey\PanelPulse\Services;

use Illuminate\Support\Facades\Http;

class LanguageService
{
    function getRouteLocale()
    {
        $lang_route = str_replace(env('APP_URL'), '', @$_SERVER['SCRIPT_URI']);
        $lang = substr_count($lang_route, '/');
        if ($lang > 0) {
            $r_e = explode('/', $lang_route);
            $langCode = $r_e[0];
        } else {
            $langCode = $lang_route;
        }
        if (in_array($langCode, ['de', 'en', 'es', 'da'])) return $langCode;
        else return '';
    }
}
