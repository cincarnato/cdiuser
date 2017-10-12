<?php

namespace CdiUser\View\Helper;

use ZfcUser\Service\User as ZfcUserUserService;
use ZfcUser\Entity\UserInterface;
use Zend\Authentication\Storage\StorageInterface;

class Impersonate extends ZfcUserUserService {

    
    protected $impersonateService;
    
    
    function getImpersonateService() {
        return $this->impersonateService;
    }

    function setImpersonateService($impersonateService) {
        $this->impersonateService = $impersonateService;
    }
    function __construct($impersonateService) {
        $this->impersonateService = $impersonateService;
    }
    
    public function __invoke(){
        return $this->isImpersonated();
    }
        
    public function isImpersonated() {
        // If the 'impersonator' (real user) storage is empty, the current user is not being impersonated.
        return !$this->getImpersonateService()->getStorageForImpersonator()->isEmpty();
    }

}
