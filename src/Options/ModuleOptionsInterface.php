<?php

namespace CdiUser\Options;

interface ModuleOptionsInterface
{
    public function getUserMapper();

    public function setUserMapper($mapper);
}
