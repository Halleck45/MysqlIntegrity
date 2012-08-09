<?php

spl_autoload_register(function($name) {
            $file = 'vendor' . DIRECTORY_SEPARATOR . preg_replace('![_\\\\]!', DIRECTORY_SEPARATOR, $name) . '.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });