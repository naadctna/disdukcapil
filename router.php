<?php
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$page = trim($path, '/');

$validPages = ['dashboard', 'tambah-masuk', 'tambah-keluar', 'rekapitulasi'];

if (in_array($page, $validPages)) {
    $_GET['page'] = $page;
    require 'index.php';
    return true;
}

if ($page === '' || $page === 'home') {
    $_GET['page'] = 'home';
    require 'index.php';
    return true;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
    return false;
}

$_GET['page'] = 'home';
require 'index.php';
return true;
?>
