<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="users_log")
 * @ORM\Entity(repositoryClass="CdiUser\Repository\UserLogRepository")
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class UserLog {

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
     * @var string
     * @ORM\Column(type="string", length=50, unique=false, nullable=true, name="sesion_id")
     */
    protected $sesionId;

    /**
     * @var \DateTime firstSesion
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="first_sesion", nullable=true)
     * @Annotation\Exclude()
     */
    protected $firstSesion;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, unique=false, nullable=true, name="first_ip")
     */
    protected $firstIp;

    /**
     * @var \DateTime lastSesion
     *
     * @ORM\Column(type="datetime", name="last_sesion", nullable=true)
     * @Annotation\Exclude()
     */
    protected $lastSesion;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, unique=false, nullable=true, name="last_ip")
     */
    protected $lastIp;

        /**
     * @var string
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true, name="login_count")
     */
    protected $loginCount;

          /**
     * @var string
     * @ORM\Column(type="string", length=120, unique=false, nullable=true, name="agent")
     */
    protected $agent;

    function getId() {
        return $this->id;
    }

    function getUser() {
        return $this->user;
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

    function setLastIp($lastIp) {
        $this->lastIp = $lastIp;
    }

    function getFirstSesion() {
        return $this->firstSesion;
    }

    function getLastSesion() {
        return $this->lastSesion;
    }

    function setFirstSesion(\DateTime $firstSesion) {
        $this->firstSesion = $firstSesion;
    }

    function setLastSesion(\DateTime $lastSesion) {
        $this->lastSesion = $lastSesion;
    }

    function getFirstIp() {
        return $this->firstIp;
    }

    function setFirstIp($firstIp) {
        $this->firstIp = $firstIp;
    }

    function getSesionId() {
        return $this->sesionId;
    }

    function setSesionId($sesionId) {
        $this->sesionId = $sesionId;
    }

    function getLoginCount() {
        return $this->loginCount;
    }

    function setLoginCount($loginCount) {
        $this->loginCount = $loginCount;
    }

    function getAgent() {
        return $this->agent;
    }

    function setAgent($agent) {
        $this->agent = $agent;
    }





}
