<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;
use ZfcRbac\Identity\IdentityInterface;
use Zend\Form\Annotation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="CdiUser\Repository\UserRepository")
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class User implements UserInterface, IdentityInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Usuario:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=true, nullable=true)
     */
    protected $username;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Password:"})
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Email:"})
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Tel:"})
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $tel;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nombre a mostrar:"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $displayName;

    /**
     * @var int
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox", "checked":"checked"})
     * @Annotation\Options({"label":"Activo:"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $state = true;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Rol:",
     * "empty_option": "",
     * "target_class":"CdiUser\Entity\Role",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="CdiUser\Entity\Role")
     * 
     */
    protected $role;

    /**
     * @var \DateTime createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     * @Annotation\Exclude()
     */
    protected $createdAt;

    /**
     * @var \DateTime updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     * @Annotation\Exclude()
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="CdiUser\Entity\Team", inversedBy="users")
     */
    private $teams;
    
     /**

     * @ORM\OneToOne(targetEntity="CdiUser\Entity\UserPicture", mappedBy="user")
     */
    private $picture;

    function __construct() {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    function getPicture() {
        return $this->picture;
    }

    function setPicture($picture) {
        $this->picture = $picture;
    }

    
    public function addTeams(\Doctrine\Common\Collections\ArrayCollection $teams) {
        foreach ($teams as $team) {
            $this->addTeam($team);
        }
    }

    public function removeTeams(\Doctrine\Common\Collections\ArrayCollection $teams) {
        foreach ($teams as $team) {
            $this->removeTeam($team);
        }
    }

    public function addTeam(\CdiUser\Entity\Team $team) {
        if ($this->teams->contains($team)) {
            return;
        }
        $this->teams[] = $team;
        $team->addUser($this); // synchronously updating inverse side
    }

    public function removeTeam(\CdiUser\Entity\Team $team) {
        if (!$this->teams->contains($team)) {
            return;
        }
        $this->teams->removeElement($team);
        $team->removeUser($this);
    }

    function getTeams() {
        return $this->teams;
    }

    function setTeams($teams) {
        $this->teams = $teams;
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

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function __toString() {
        return $this->toString();
    }

    public function toString() {
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
        if ($this->getRole()) {
            return [$this->getRole()->getName()];
        } else {
            return [];
        }
    }

}
