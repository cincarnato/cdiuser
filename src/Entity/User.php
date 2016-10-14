<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class User implements UserInterface, IdentityInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var int
     */
    protected $state;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="CdiUser\Entity\Role")
     * 
     */
    protected $role;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $tel;

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
    
    /**
     * @var Collection
     */
    private $roles;

    public function __construct() {
        $this->roles = new ArrayCollection();
    }

   

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getDisplayName() {
        return $this->displayName;
    }

    function getState() {
        return $this->state;
    }

    function getRole() {
        return $this->role;
    }

    function getTel() {
        return $this->tel;
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

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    function setState($state) {
        $this->state = $state;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setLastKeepalive(\DateTime $lastKeepalive) {
        $this->lastKeepalive = $lastKeepalive;
    }

    function setLastIp($lastIp) {
        $this->lastIp = $lastIp;
    }

    public function __toString() {
        if ($this->username != "") {
            return $this->username;
        } else {
            return $this->email;
        }
    }

     /**
     * {@inheritDoc}
     */
    public function getRoles() {
        return [$this->getRole()->getName()];
    }

    /**
     * Set the list of roles
     * @param Collection $roles
     */
    public function setRoles(Collection $roles) {
        $this->roles->clear();
          $this->roles[] = $this->role;
    }

    /**
     * Add one role to roles list
     * @param \Rbac\Role\RoleInterface $role
     */
    public function addRole(RoleInterface $role) {
        $this->roles[] = $role;
    }
}
