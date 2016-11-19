<?php

namespace CdiUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZfcRbac\Permission\PermissionInterface;
use Zend\Form\Annotation;
/**
 * @ORM\Entity
 * @ORM\Table(name="permissions")
 */
class Permission implements PermissionInterface {

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
     * @Annotation\Options({"label":"Permiso:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":128}})
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $name;

    /**
     * Constructor
     */
    public function __construct($name) {
        $this->name = (string) $name;
    }

    /**
     * Get the permission identifier
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString() {
        return $this->name;
    }
    
    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }



}
