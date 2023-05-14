<?php

namespace TheIconic\NameParser;

if (!function_exists('TheIconic\NameParser\strlen')) {
    function strlen(string $string): int
    {
        return \mb_strlen($string, 'UTF-8');
    }
}

if (!function_exists('TheIconic\NameParser\tcword')) {
    function tcword(string $string): string
    {
        return \mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }
}

if (!function_exists('TheIconic\NameParser\characters')) {
    function characters(string $string): array
    {
        return \preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
}

if (!function_exists('TheIconic\NameParser\substr')) {
    function substr(string $string, int $start, int $length = null): string
    {
        return \mb_substr($string, $start, $length, 'UTF-8');
    }
}

if (!function_exists('TheIconic\NameParser\strtoupper')) {
    function strtoupper(string $string): string
    {
        return \mb_strtoupper($string, 'UTF-8');
    }
}

if (!function_exists('TheIconic\NameParser\strpos')) {
    function strpos(string $haystack, string $needle, int $offset = 0): int
    {
        return \mb_strpos($haystack, $needle, $offset, 'UTF-8');
    }
}