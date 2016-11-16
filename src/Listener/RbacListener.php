<?php

namespace CdiUser\Listener;

use Zend\EventManager\EventInterface;
use Zend\Navigation\Page\AbstractPage;
use ZfcRbac\Service\AuthorizationServiceInterface;

class RbacListener
{
    /**
     * @var AuthorizationServiceInterface
     */
    protected $authorizationService;

    /**
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function __construct(AuthorizationServiceInterface $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    /**
     * @param  EventInterface $event
     * @return bool|void
     */
    public function accept(EventInterface $event)
    {
        $page = $event->getParam('page');

        if (!$page instanceof AbstractPage) {
            return;
        }

        $permission = $page->getPermission();

        if (is_null($permission)) {
            $event->stopPropagation();
            return false;
        }

        $event->stopPropagation();

        return $this->authorizationService->isGranted($permission);
    }
}
