<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initDatabase(){
    $db = $this->getPluginResource('db')->getDbAdapter();
    Zend_Registry::set('db', $db);   
  }

  protected function _initAcl(){
    $acl = new Zend_Acl();
      $acl->addRole(new Zend_Acl_Role('user'))
          ->addRole(new Zend_Acl_Role('staff'))
          ->addRole(new Zend_Acl_Role('leader'))
          ->addRole(new Zend_Acl_Role('expert'))
          ->addRole(new Zend_Acl_Role('master'))
          ->addRole(new Zend_Acl_Role('admin'));
      $acl->addResource(new Zend_Acl_Resource('admin:index'));
      $acl->addResource(new Zend_Acl_Resource('admin:user'));      
      $acl->addResource(new Zend_Acl_Resource('default:index'));
      $acl->addResource(new Zend_Acl_Resource('default:user')); 
      $acl->allow('admin','admin:index',null);
      $acl->allow('admin','admin:user',null);
      $acl->allow(null,'default:index',null);
      $acl->allow(null,'default:user',null);
      Zend_Registry::set('acl', $acl);
  }
} 