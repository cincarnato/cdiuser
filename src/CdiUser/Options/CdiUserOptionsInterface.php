<?php

namespace CdiUser\Options;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author cincarnato
 */
interface CdiUserOptionsInterface {

   public function getSessionLifeTime();
   public function setSessionLifeTime($lifeTime);
   
   public function setKeepalive($keepalive);
   public function getKeepalive();
   
    public function setRegisterSession($registerSession);
   public function getRegisterSession();
   
}

?>
