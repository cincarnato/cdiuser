<?php

namespace CdiUser\Options;

interface UserEditOptionsInterface
{
    public function getEditFormElements();

    public function setEditFormElements(array $elements);

    public function getAllowPasswordChange();

    public function setAdminPasswordChange($allowPasswordChange);
}
