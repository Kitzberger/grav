<?php
namespace Grav\Common\Processors;

class InitializeProcessor extends ProcessorBase implements ProcessorInterface {

    public $id = 'init';
    public $title = 'Initialize';

    public function process() {
      $this->container['config']->debug();

      // Use output buffering to prevent headers from being sent too early.
      ob_start();
      if ($this->container['config']->get('system.cache.gzip')) {
          // Enable zip/deflate with a fallback in case of if browser does not support compressing.
          if (!ob_start("ob_gzhandler")) {
              ob_start();
          }
      }

      // Initialize the timezone.
      if ($this->container['config']->get('system.timezone')) {
          date_default_timezone_set($this->container['config']->get('system.timezone'));
      }

      // Initialize uri, session.
      $this->container['uri']->init();
      $this->container['session']->init();

      $this->container->setLocale();
    }

}
