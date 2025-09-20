<?php

if (!function_exists('formatear_distancia')) {
    function formatear_distancia($metros)
    {
        $metros = (int) $metros;

        if ($metros < 1000) {
            return "{$metros} m";
        }

        $km = floor($metros / 1000);
        $resto = $metros % 1000;

        if ($resto === 0) {
            return "{$km} km";
        }

        return "{$km} km {$resto} m";
    }
}
