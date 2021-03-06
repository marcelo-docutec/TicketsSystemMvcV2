<?php

require "config/autoload.php";
require "config/config.php";
require "helpers/session.php";
require 'vendor/autoload.php';

use config\Autoload as Autoload;
use config\Request as Request;
use config\Router as Router;
use helpers\Session as Session;


//##################################################
if ( ! function_exists('array_key_first')) {
    /**
     * Gets the first key of an array
     *
     * @param array $array
     * @return mixed
     */
    function array_key_first(array $array)
    {
        if (count($array)) {
            reset($array);
            return key($array);
        }

        return null;
    }
}
////

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** ESTO ES PARA CAPTURAR WARNINGS */
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}

date_default_timezone_set('America/Argentina/Buenos_Aires');

Autoload::start();
Router::go(new Request());
