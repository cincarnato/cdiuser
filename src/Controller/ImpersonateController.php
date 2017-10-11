<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail;
use Zend\Crypt\Password\Bcrypt;

class ImpersonateController extends AbstractActionController {

    /** @var array */
    protected $moduleOptions;

    /**
     * @var \CdiUser\Service\Impersonate
     */
    protected $userService;

    function getUserService() {
        return $this->userService;
    }
    
    function getModuleOptions() {
        return $this->moduleOptions;
    }

    
    function __construct($service, $moduleOptions) {
        $this->userService = $service;
        $this->moduleOptions = $moduleOptions;
    }

    public function impersonateUserAction() {
        // Start impersonating the user specified by the user id route parameter specified in config.
        $this->getUserService()->impersonate($this->params()->fromRoute('userId'));

        // Redirect to the post impersonation redirect route, if specified in config.
        $impersonateRedirectRoute = $this->getModuleOptions()->getImpersonateRedirectRoute();
        if (!empty($impersonateRedirectRoute)) {
            return $this->redirect()->toRoute($impersonateRedirectRoute);
        }
    }

    public function unimpersonateUserAction() {
        // Stop impersonating the currently impersonated user.
        $this->getUserService()->unimpersonate();

        // Redirect to the post impersonation redirect route, if specified in config.
        $unimpersonateRedirectRoute = $this->getModuleOptions()->getUnImpersonateRedirectRoute();
        if (!empty($unimpersonateRedirectRoute)) {
            return $this->redirect()->toRoute($unimpersonateRedirectRoute);
        }
    }

}
