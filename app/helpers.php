<?php

if (!function_exists('currency')) {
    function currency($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}