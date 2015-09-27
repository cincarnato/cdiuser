<?php

namespace CdiUser\Service;

use Zend\Authentication\AuthenticationService;
use CdiUser\Options\CdiUserOptionsInterface;

/**
 * Description of GoogleApiAnalytics
 *
 * @author cincarnato
 */
class UserSession {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $sm;
    protected $keepalive = 120;
    protected $sessionLifeTime = 122; //seconds (600 = 10 Min)
    protected $registerSession = false;

    public function __construct(CdiUserOptionsInterface $options, \Doctrine\ORM\EntityManager $em, $sm) {
        if ($options->getSessionLifeTime()) {
            $this->sessionLifeTime = $options->getSessionLifeTime();
        }
        if ($options->getKeepalive()) {
            $this->keepalive = $options->getKeepalive();
        }
        if ($options->getRegisterSession()) {
            $this->registerSession = $options->getRegisterSession();
        }
        $this->em = $em;
        $this->sm = $sm;
    }

    public function getUsersActives() {
        $lastKeepalive = new \DateTime("now");
        $lastKeepalive->modify("-" . $this->sessionLifeTime . " seconds");
        $query = $this->em->createQueryBuilder()
                ->select('u')
                ->from('CdiUser\Entity\User', 'u')
                ->where('u.lastKeepalive > :lk ')
                ->setParameter("lk", $lastKeepalive);

        $colUsers = $query->getQuery()->getResult();
        if ($colUsers) {
            return $colUsers;
        } else {
            return null;
        }
    }

    public function getDateUserLife() {
        $lastKeepalive = new \DateTime("now");
        $lastKeepalive->modify("-" . $this->sessionLifeTime . " seconds");
        return $lastKeepalive;
    }

    public function registerKeepalive() {
        if ($this->registerSession) {
            $auth = $this->sm->get('zfcuser_auth_service');
            if ($auth->hasIdentity()) {
                $user = $auth->getIdentity();

                $user->setLastKeepalive(new \DateTime("now"));
                $this->getEm()->persist($user);
                $this->getEm()->flush();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

}

?>
