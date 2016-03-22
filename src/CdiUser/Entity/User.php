<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CdiUser\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class User implements UserInterface, ProviderInterface
{
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
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var int
     */
    protected $state;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="CdiUser\Entity\Role")
     * 
     */
    protected $roles;

    
    
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
     * Initialies the roles variable.
     */
    public function __construct()
    {
        //$this->roles = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     *
     * @return void
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
        /**
     * Get role.
     *
     * @return array
     */
    public function getRols()
    {
      
        return $this->roles;
    }


    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
      
        return $this->roles;
    }

    /**
     * Set a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function setRoles($role)
    {
        $this->roles = $role;
    }
    
    public function getTel() {
        return $this->tel;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }
    
    function getLastKeepalive() {
        return $this->lastKeepalive;
    }

    function getLastIp() {
        return $this->lastIp;
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


            $explode = explode("@", $this->email);
            $userName = $explode[0];

            return $userName;
        }
    }
    



}
