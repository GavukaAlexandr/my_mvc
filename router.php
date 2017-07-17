<?php

if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // сервер возвращает файлы напрямую.
} else {
    include __DIR__ . '/index.php';
}
/**
 * this file for router without .htaccess
 */


