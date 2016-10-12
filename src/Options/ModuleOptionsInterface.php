<?php

namespace CdiUser\Options;

interface ModuleOptionsInterface
{
    public function getUserMapper();

    public function setUserMapper($mapper);
    
    public function getCreateUserAutoPassword();

    public function setCreateUserAutoPassword($createUserAutoPassword);

    public function getCreateFormElements();

    public function setCreateFormElements(array $elements);
    
     public function getEditFormElements();

    public function setEditFormElements(array $elements);

    public function getAllowPasswordChange();

    public function setAllowPasswordChange($allowPasswordChange);
}
