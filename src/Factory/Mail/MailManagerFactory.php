<?php
namespace CdiUser\Factory\Mail;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;
class MailManagerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $moduleOptions = $container->get('cdiuser_module_options');
        $smptOptions = new SmtpOptions($moduleOptions->getTransportOptions());
        $className = $moduleOptions->getTransport();
        $transport = new $className;
        $transport->setOptions($smptOptions);
        $viewRender = $container->get('ViewRenderer');
        
        return new \CdiUser\Mail\MailManager($transport,$viewRender);        
    }
}
