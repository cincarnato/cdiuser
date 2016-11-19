<?php

namespace CdiUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail;
use Zend\Crypt\Password\Bcrypt;

class UserController extends AbstractActionController {

    /** @var array */
    protected $options;

    /** @var array */
    protected $zfcUserOptions;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \CdiUser\Form\LostPasswordForm
     */
    protected $lpForm;

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function getLpForm() {
        return $this->lpForm;
    }

    function setLpForm(\CdiUser\Form\LostPasswordForm $lpForm) {
        $this->lpForm = $lpForm;
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiUser\Form\LostPasswordForm $lpForm, $options, $zfcUserOptions) {
        $this->em = $em;
        $this->lpForm = $lpForm;
        $this->options = $options;
        $this->zfcUserOptions = $zfcUserOptions;
    }

    public function lpassAction() {

        //IF POST
        if ($this->getRequest()->isPost()) {

            //SET DATA TO FORM
            $data = $this->getRequest()->getPost();
            $this->lpForm->setData($data);

            //VALID FORM
            if ($this->lpForm->isValid()) {

                //DO SOMETHING IF FORM IS VALID
                $user = $this->getEm()->getRepository("\CdiUser\Entity\User")->findByEmail($data["email"]);

                $bcrypt = new Bcrypt;
                $bcrypt->setCost($this->zfcUserOptions->getPasswordCost());
                $newRandomPassword = $this->generateRandomPassword();
                $user->setPassword($bcrypt->create($newRandomPassword));

                $this->getEm()->persist($user);
                $this->getEm()->flush();

                $this->email($user, $newRandomPassword);

                //FORWARD - IF NEED
                return $this->forward()->dispatch('cdiuser', ['action' => 'ok']);
            } else {
                //DO SOMETHING IF FORM IS INVALID
            }
        }


        return array("form" => $this->lpForm);
    }

    public function okAction() {
        
    }

    protected function generateRandomPassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function email($user, $newRandomPassword) {
        $mailOptions = $this->options->getMail();
        $mail = new Mail\Message();
        $mail->setBody($this->body($user, $mailOptions, $newRandomPassword));
        $mail->setFrom($mailOptions["message"]["fromMail"], $mailOptions["message"]["fromName"]);
        $mail->addTo($user->getEmail(), $user->toString());
        $mail->setSubject('Recuperación de Password');
        
        //TO IMPROVE
        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
    }

    protected function body($user, $mailOptions, $newRandomPassword) {
        $body = "Hola " . $user . ", \n\n";
        $body .= "Tu nueva password para el sitio " . $mailOptions["message"]["web"] . " es:\n\n";
        $body .= $newRandomPassword;


        return $body;
    }

}
