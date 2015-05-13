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
      $acl->addResource(new Zend_Acl_Resource('admin:building'));
      $acl->addResource(new Zend_Acl_Resource('admin:institute'));
      $acl->addResource(new Zend_Acl_Resource('admin:room'));
      $acl->addResource(new Zend_Acl_Resource('admin:device'));
      $acl->addResource(new Zend_Acl_Resource('admin:attribute'));
      $acl->addResource(new Zend_Acl_Resource('admin:category'));
      $acl->addResource(new Zend_Acl_Resource('admin:factory'));
      $acl->addResource(new Zend_Acl_Resource('admin:provider'));
      $acl->addResource(new Zend_Acl_Resource('admin:type'));
      $acl->addResource(new Zend_Acl_Resource('admin:status'));
      $acl->addResource(new Zend_Acl_Resource('admin:country'));
      $acl->addResource(new Zend_Acl_Resource('admin:increase'));
      $acl->addResource(new Zend_Acl_Resource('admin:disposal'));
      $acl->addResource(new Zend_Acl_Resource('admin:repair'));
      $acl->addResource(new Zend_Acl_Resource('admin:reuse'));
      $acl->addResource(new Zend_Acl_Resource('admin:transfer'));
      $acl->addResource(new Zend_Acl_Resource('default:index'));
      $acl->addResource(new Zend_Acl_Resource('default:user'));
      $acl->allow('admin');
      $acl->allow(null,'default:index',null);
      $acl->allow(null,'default:user',null);
      Zend_Registry::set('acl', $acl);
  }
} 