<?php
namespace CdiUser\Factory\Controller\Plugin;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
class CdiUserMailFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $mail =  $container->get(\CdiUser\Mail\MailManager::class);
        
        return new \CdiUser\Controller\Plugin\CdiUserMail($mail);
    }
}
