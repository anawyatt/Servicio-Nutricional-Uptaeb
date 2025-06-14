<?php 


if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    return "Error: no se encontró el autoload.";
}

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use config\componentes\configSistema as configSistema;

$GlobalConfig = new configSistema();
$GlobalConfig->_int();

use bin\controlador\frontControlador as frontControlador;

$IndexSystem = new frontControlador($_REQUEST);

?>
