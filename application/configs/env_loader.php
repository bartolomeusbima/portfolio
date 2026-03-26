<?php

if (!function_exists('loadEnvFile')) {
    function loadEnvFile($path)
    {
        if (!is_readable($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            if ($key === '') {
                continue;
            }

            $length = strlen($value);
            if ($length >= 2) {
                $first = $value[0];
                $last = $value[$length - 1];
                if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                    $value = substr($value, 1, -1);
                }
            }

            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv($key . '=' . $value);
        }
    }
}

if (!function_exists('loadAppEnvFiles')) {
    function loadAppEnvFiles($basePath)
    {
        $basePath = rtrim((string) $basePath, '/');
        if ($basePath === '') {
            return;
        }

        $projectEnvPath = $basePath . '/.env';
        $parentEnvPath = dirname($basePath) . '/.env';

        loadEnvFile($projectEnvPath);

        $appEnv = getenv('APP_ENV') ?: 'local';
        if ($appEnv === 'local') {
            return;
        }

        loadEnvFile($parentEnvPath);

        if (getenv('DB_HOST') === false || getenv('DB_HOST') === '') {
            loadEnvFile($projectEnvPath);
        }
    }
}
