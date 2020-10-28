<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="users_log_detail")
 * @ORM\Entity(repositoryClass="CdiUser\Repository\UserLogDetailRepository")
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class UserLogDetail {

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
     * @ORM\Column(type="datetime", name="date_sesion", nullable=true)
     * @Annotation\Exclude()
     */
    protected $dateSesion;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, unique=false, nullable=true, name="ip")
     */
    protected $ip;

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

    function getSesionId() {
        return $this->sesionId;
    }

    function getDateSesion() {
        return $this->dateSesion;
    }

    function getIp() {
        return $this->ip;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSesionId($sesionId) {
        $this->sesionId = $sesionId;
    }

    function setDateSesion(\DateTime $dateSesion) {
        $this->dateSesion = $dateSesion;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function getAgent() {
        return $this->agent;
    }

    function setAgent($agent) {
        $this->agent = $agent;
    }

}
