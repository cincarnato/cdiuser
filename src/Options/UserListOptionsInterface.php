<?php

namespace CdiUser\Options;

interface UserListOptionsInterface
{
    public function getUserListElements();

    public function setUserListElements(array $elements);
}
