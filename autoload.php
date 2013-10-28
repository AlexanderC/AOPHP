<?php
/**
 * @author AlexanderC <self@alexanderc.me>
 * @date 10/28/13
 * @time 8:21 PM
 */

spl_autoload_register(function ($class) {
    $rawParts = explode("\\", $class);

    if (count($rawParts) <= 0) {
        return false;
    }

    if ($rawParts[0] == "AOPHP") {
        $path = __DIR__ . '/src/';
        $parts = $rawParts;

        $file = realpath($path . implode("/", $parts) . ".php");

        return is_file($file) ? require $file : false;
    } else {
        $path = __DIR__ . '/tests/';
        $parts = & $rawParts;
        $file = realpath($path . implode("/", $parts) . ".php");

        return is_file($file) ? require $file : false;
    }
});