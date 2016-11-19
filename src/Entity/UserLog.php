<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_users_log")
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class UserLog  {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="CdiUser\Entity\User")
     * 
     */
    protected $user;

    /**
     * @var \DateTime updatedAt
     *
     * @ORM\Column(type="datetime", name="updated_at", nullable=true, name="last_keepalive")
     */
    protected $lastKeepalive;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, unique=false, nullable=true, name="last_ip")
     */
    protected $lastIp;


    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
    }

    function getLastKeepalive() {
        return $this->lastKeepalive;
    }

    function getLastIp() {
        return $this->lastIp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setLastKeepalive(\DateTime $lastKeepalive) {
        $this->lastKeepalive = $lastKeepalive;
    }

    function setLastIp($lastIp) {
        $this->lastIp = $lastIp;
    }



}
