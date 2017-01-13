<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="CdiUser\Repository\TeamRepository")
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Team {

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
     * @ORM\ManyToMany(targetEntity="CdiUser\Entity\User", mappedBy="teams")
     */
    private $users;

    function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addUsers(\Doctrine\Common\Collections\ArrayCollection $users) {
        foreach ($users as $user) {
            $this->addUser($user);
        }
    }

    public function removeUsers(\Doctrine\Common\Collections\ArrayCollection $users) {
        foreach ($users as $user) {
            $this->removeUser($user);
        }
    }

    public function addUser(\CdiUser\Entity\User $user) {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users[] = $user;
        $user->addTeam($this); // synchronously updating inverse side
    }

    public function removeUser(\CdiUser\Entity\User $user) {
        if (!$this->users->contains($user)) {
            return;
        }

        $user->removeTeam($this);
        $this->users->removeElement($user);
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

    public function __toString() {
        return $this->name;
    }

}
