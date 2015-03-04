 <?php
define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . '/application'));
define('APPLICATION_ENV','production');
set_include_path(realpath(dirname(__FILE__) . '/library'));
require_once 'Zend/Application.php' ;
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()->run();
