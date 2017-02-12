<?php ##

$project_root = $_SERVER['DOCUMENT_ROOT'];

require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";

// Подключаемся к БД.
$db = DbSimple_Generic::connect('mysqli://root@localhost/ads_base');

// Устанавливаем обработчик ошибок.
$db->setErrorHandler('databaseErrorHandler');
//$db->setLogger('myLogger');

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>";
    print_r($info);
    echo "</pre>";
    exit();
}
?>