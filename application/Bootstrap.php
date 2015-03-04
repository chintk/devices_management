<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initDatabase(){
    $db = $this->getPluginResource('db')->getDbAdapter();
    Zend_Registry::set('db', $db);   
  }
//   protected function _initAutoload(){
//     $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
//         'basePath'  => APPLICATION_PATH,
//         'namespace' => 'Default',
//     ));
//     $resourceLoader->addResourceType('form','forms/','Form');
// }  
} 