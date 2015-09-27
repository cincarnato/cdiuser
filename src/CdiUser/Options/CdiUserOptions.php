<?php

namespace CdiUser\Options;

use Zend\Stdlib\AbstractOptions;

class CdiUserOptions extends AbstractOptions implements
CdiUserOptionsInterface {

    protected $sessionLifeTime;
    protected $keepalive;
   protected $registerSession;
      /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    function getSessionLifeTime() {
        return $this->sessionLifeTime;
    }

    function setSessionLifeTime($sessionLifeTime) {
        $this->sessionLifeTime = $sessionLifeTime;
    }
    
    function getKeepalive() {
        return $this->keepalive;
    }

    function setKeepalive($keepalive) {
        $this->keepalive = $keepalive;
    }

    function getRegisterSession() {
        return $this->registerSession;
    }

    function setRegisterSession($registerSession) {
        $this->registerSession = $registerSession;
    }







}
