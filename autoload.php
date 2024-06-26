<?php

    use function Itrk\Functions\itrk_path;

    const ITRK_DIR = __DIR__;

    require_once __DIR__ . '/functions.php';

    /**
     * Klassen-Autoloader
     * Alle Klassen befinden sich innerhalb des /Itrk/ Verzeichnisses
     */
    spl_autoload_register(function ($name) {
        $name = str_replace("\\", DIRECTORY_SEPARATOR, $name);
        $file = itrk_path($name . '.php');
        if (is_file($file)) {
            require_once $file;
        }
    });
