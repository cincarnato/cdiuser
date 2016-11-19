<?php

namespace CdiUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Role\HierarchicalRoleInterface;
use ZfcRbac\Permission\PermissionInterface;
use Doctrine\Common\Collections\Criteria;
use Zend\Form\Annotation;
/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role implements HierarchicalRoleInterface {

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

    /**
     * @var string|null
      * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nombre:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":48}})
     * @ORM\Column(type="string", length=48, unique=true)
     */
    protected $name;

    /**
     * @var HierarchicalRoleInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Role")
     */
    protected $children = [];

    /**
     * @var PermissionInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Permission", indexBy="name", fetch="LAZY")
     */
    protected $permissions;

    /**
     * Init the Doctrine collection
     */
    public function __construct() {
        $this->children = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * Get the role identifier
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the role name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name) {
        $this->name = (string) $name;
    }

    /**
     * Get the role name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function addChild(HierarchicalRoleInterface $child) {
        $this->children[] = $child;
    }

    /**
     * {@inheritDoc}
     */
    public function addPermission($permission) {
        if (is_string($permission)) {
            $permission = new Permission($permission);
        }

        $this->permissions[(string) $permission] = $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermission($permission) {
        // This can be a performance problem if your role has a lot of permissions. Please refer
        // to the cookbook to an elegant way to solve this issue

        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', (string) $permission));
        $result = $this->permissions->matching($criteria);

        return count($result) > 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * {@inheritDoc}
     */
    public function hasChildren() {
        return !$this->children->isEmpty();
    }

    public function __toString() {
        return $this->name;
    }

}
