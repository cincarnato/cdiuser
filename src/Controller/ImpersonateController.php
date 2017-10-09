<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail;
use Zend\Crypt\Password\Bcrypt;

class ImpersonateController extends AbstractActionController
{

    /** @var array */
    protected $moduleOptions;

    /** @var array */
    protected $zfcUserOptions;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Description
     *
     * @var \CdiDataGrid\Grid
     */
    protected $grid;

    function getEm()
    {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }


    function __construct($service, $moduleOptions)
    {
        $this->userService = $service;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * The user service which provides the impersonation functions.
     *
     * @var \ZfcUser\Service\User
     */
    protected $userService;

    public function impersonateUserAction()
    {
        // Retrieve config used for customisation of this action.
        $config = $this->getConfig();

        // Start impersonating the user specified by the user id route parameter specified in config.
        $this->getUserService()->impersonate($this->params()->fromRoute('userId'));

        // Redirect to the post impersonation redirect route, if specified in config.
        $impersonateRedirectRoute = $config->getImpersonateRedirectRoute();
        if (!empty($impersonateRedirectRoute)) {
            return $this->redirect()->toRoute($impersonateRedirectRoute);
        }
    }


    public function unimpersonateUserAction()
    {
        // Retrieve config used for customisation of this action.
        $config = $this->getConfig();

        // Stop impersonating the currently impersonated user.
        $this->getUserService()->unimpersonate();

        // Redirect to the post impersonation redirect route, if specified in config.
        $unimpersonateRedirectRoute = $config->getUnimpersonateRedirectRoute();
        if (!empty($unimpersonateRedirectRoute)) {
            return $this->redirect()->toRoute($unimpersonateRedirectRoute);
        }
    }


}
