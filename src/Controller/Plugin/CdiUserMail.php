<?php
namespace CdiUser\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class CdiUserMail extends AbstractPlugin {
    
    /**
     *
     * @var \CdiUser\Mail\MailManager
     */
    private $mail;
    
    function __invoke()
    {
        return $this->getMail();
    }
   
    function __construct(\CdiUser\Mail\MailManager $mail) {
        $this->mail = $mail;
    }



    
}
