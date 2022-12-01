<?php

if (!function_exists('formatMobile')) {
    function formatMobile($mobile)
    {
        return substr(preg_replace('/^\+?1|\|1|\D/', '', $mobile), -11);
    }
}
