 <?php
define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . '/application'));
define('APPLICATION_NAME', substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
define('APPLICATION_ENV','production');
set_include_path(realpath(dirname(__FILE__) . '/library'));
require_once 'Zend/Application.php' ;
$application = new Zend_Application(
    APPLICATION_ENV,
    array(
        'config' => array(
            APPLICATION_PATH . '/configs/application.ini',
            APPLICATION_PATH . '/configs/database.ini'
        )
    )
);
$application->bootstrap()->run();
