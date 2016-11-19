<?php

namespace CdiUser\Service;

use Zend\Form\Form;
use Zend\Math\Rand;
use Zend\Crypt\Password\Bcrypt;
use CdiUser\EventManager\EventProvider;
use ZfcUser\Entity\UserInterface;
use CdiUser\Options\ModuleOptions;
use ZfcUser\Mapper\UserInterface as UserMapperInterface;
use ZfcUser\Options\ModuleOptions as ZfcUserModuleOptions;


class User extends EventProvider
{

    /**
     * @var UserMapperInterface
     */
    protected $userMapper;

    /**
     * @var \ZfcUser\Options\UserServiceOptionsInterface
     */
    protected $cdiUserOptions;

    /**
     * @var ZfcUserModuleOptions
     */
    protected $zfcUserOptions;

      public function __construct(
        UserMapperInterface $userMapper,
        ModuleOptions $cdiUserOptions,
        ZfcUserModuleOptions $zfcUserOptions
    ) {
        $this->userMapper = $userMapper;
        $this->cdiUserOptions = $cdiUserOptions;
        $this->zfcUserOptions = $zfcUserOptions;
  
    }
/**
     * @param Form $form
     * @param array $data
     * @return UserInterface|null
     */
    public function create(Form $form, array $data)
    {
        $zfcUserOptions = $this->getZfcUserOptions();
        $user = $form->getData();
        $argv = array();
        if ($this->getCdiUserOptions()->getCreateUserAutoPassword()) {
            $argv['password'] = $this->generatePassword();
        } else {
            $argv['password'] = $user->getPassword();
        }
        $bcrypt = new Bcrypt;
        $bcrypt->setCost($zfcUserOptions->getPasswordCost());
        $user->setPassword($bcrypt->create($argv['password']));
        foreach ($this->getCdiUserOptions()->getCreateFormElements() as $element) {
            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
        }
        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->getUserMapper()->insert($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }
    /**
     * @param Form $form
     * @param array $data
     * @param UserInterface $user
     * @return UserInterface
     */
    public function edit(Form $form, array $data, UserInterface $user,$originalPassword)
    {
        // first, process all form fields
//        foreach ($data as $key => $value) {
//            if ($key == 'password') continue;
//            $setter = $this->getAccessorName($key);
//            if (method_exists($user, $setter)) call_user_func(array($user, $setter), $value);
//        }
        $argv = array();
        // then check if admin wants to change user password
        if ($this->getCdiUserOptions()->getAllowPasswordChange()) {
            if (!empty($data['reset_password'])) {
                $argv['password'] = $this->generatePassword();
            } elseif (!empty($data['password'])) {
                $argv['password'] = $data['password'];
            }
            
  
            if (!empty($argv['password'])) {
                $bcrypt = new Bcrypt();
                $bcrypt->setCost($this->getZfcUserOptions()->getPasswordCost());
                $user->setPassword($bcrypt->create($argv['password']));
            }else{
                $user->setPassword($originalPassword);
            }
        }
//        // TODO: not sure if this code is required here - all fields that came from the form already saved
//        foreach ($this->getCdiUserOptions()->getEditFormElements() as $element) {
//            call_user_func(array($user, $this->getAccessorName($element)), $data[$element]);
//        }
        $argv += array('user' => $user, 'form' => $form, 'data' => $data);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $argv);
        $this->getUserMapper()->update($user);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $argv);
        return $user;
    }
    /**
     * @return string
     */
    public function generatePassword()
    {
        return Rand::getString($this->getCdiUserOptions()->getAutoPasswordLength());
    }
    protected function getAccessorName($property, $set = true)
    {
        $parts = explode('_', $property);
        array_walk($parts, function (&$val) {
            $val = ucfirst($val);
        });
        return (($set ? 'set' : 'get') . implode('', $parts));
    }
    public function getUserMapper()
    {
        return $this->userMapper;
    }
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        return $this;
    }
    public function setCdiUserOptions(ModuleOptions $cdiUserOptions)
    {
        $this->cdiUserOptions = $cdiUserOptions;
        return $this;
    }
    public function getCdiUserOptions()
    {
        return $this->cdiUserOptions;
    }
    public function setZfcUserOptions(ZfcUserModuleOptions $cdiUserOptions)
    {
        $this->zfcUserOptions = $cdiUserOptions;
        return $this;
    }
    /**
     * @return \ZfcUser\Options\ModuleOptions
     */
    public function getZfcUserOptions()
    {
        return $this->zfcUserOptions;
    }
}

