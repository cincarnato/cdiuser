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
 * @ORM\Table(name="group")
 * @ORM\Entity(repositoryClass="CdiUser\Repository\GroupRepository")
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Group {

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
     * @Annotation\Options({"label":"Nombre:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     */
    protected $name;

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
     * Many Groups have Many Users.
     * @ManyToMany(targetEntity="CdiUser\Entity\User", mappedBy="groups")
     */
    private $users;

    function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addUser(\CdiUser\Entity\User $user) {
        $user->addGroup($this); // synchronously updating inverse side
        $this->users[] = $user;
    }

    function getUsers() {
        return $this->users;
    }

    function setUsers($users) {
        $this->users = $users;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}
