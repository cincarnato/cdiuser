<?php

namespace CdiUser\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_picture")
 * @ORM\Entity(repositoryClass="CdiUser\Repository\UserPictureRepository")
 */
class UserPicture {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Attributes({"type":"hidden"})
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    public $id = null;

    /**
     * @Annotation\Type("Zend\Form\Element\File")
     * @Annotation\Attributes({"type":"file"})
     * @Annotation\Options({"label":""})
     * @ORM\Column(type="string", length=200, unique=false, nullable=true, name="picture")
     */
    public $picture = null;

    /**
     * 
     * @ORM\OneToOne(targetEntity="CdiUser\Entity\User")
     * 
     */
    protected $user;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function __toString() {
        return (string) $this->id;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function setPicture($picture) {
        if (is_array($picture)) {
            $tmpName = $picture['tmp_name'];
            if (preg_match("/\/media\/user\/.*/", $tmpName, $m)) {
                $name = $m[0];
            } else {
                $name = $tmpName;
            }
            $this->picture = $name;
        } else {
            $this->picture = $picture;
        }
    }

    public function getImagen_wp() {
        return "/media/user/";
    }

    public function getImagen_fp() {
        return "/media/user/" . $this->picture;
    }

    function getUser() {
        return $this->user;
    }

    function setUser($user) {
        $this->user = $user;
    }

}
