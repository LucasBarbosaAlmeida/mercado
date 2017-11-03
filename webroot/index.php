<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEW_PATH', ROOT . DS . 'views');

use Lib\App;

require_once ROOT . DS . 'lib' . DS . 'init.php';

session_start();

try {
    App::run();
} catch (Exception $ex) {
    echo "Erro inesperado: {$ex->getMessage()}";
}

\Lib\DB::close();

//$db = App::getDb();
//$con = $db->getConnection();
//$res = $con->query("SELECT * FROM Pagina");
//while ($row = $res->fetch_assoc()) {
//    var_dump($row);
//}