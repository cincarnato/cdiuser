<?php

namespace CdiUser\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements
ModuleOptionsInterface {

    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     *
     * @var array()
     */
    private $transportOptions;

    /**
     * @var string
     */
    private $transport;

    /**
     * @var string
     */
    private $mailFrom;
    
    
        /**
     * @var string
     */
    private $mailFromName;
    
    /**
     * @var string
     */
    private $mailTemplatePasswordRecovery = 'cdi-user/mail/password-recovery';
    
     /**
     * @var string
     */
    private $mailTemplatePasswordSend = 'cdi-user/mail/password-send';
    
    
    /**
     * Array of data to show in the user list
     * Key = Label in the list
     * Value = entity property(expecting a 'getProperty())
     */
    protected $userListElements = array('Id' => 'id', 'Email address' => 'email');

    /**
     * Array of form elements to show when editing a user
     * Key = form label
     * Value = entity property(expecting a 'getProperty()/setProperty()' function)
     */
    protected $editFormElements = array();

    /**
     * Array of form elements to show when creating a user
     * Key = form label
     * Value = entity property(expecting a 'getProperty()/setProperty()' function)
     */
    protected $createFormElements = array();

    /**
     * @var bool
     * true = create password automaticly
     * false = administrator chooses password
     */
    protected $createUserAutoPassword = true;

    /**
     * @var int
     * Length of passwords created automatically
     */
    protected $autoPasswordLength = 8;

    /**
     * @var bool
     * Allow change user password on user edit form.
     */
    protected $allowPasswordChange = true;
    protected $userMapper = 'CdiUser\Mapper\UserDoctrine';

    public function setUserMapper($userMapper) {
        $this->userMapper = $userMapper;
    }

    public function getUserMapper() {
        return $this->userMapper;
    }

    public function setUserListElements(array $listElements) {
        $this->userListElements = $listElements;
    }

    public function getUserListElements() {
        return $this->userListElements;
    }

    public function getEditFormElements() {
        return $this->editFormElements;
    }

    public function setEditFormElements(array $elements) {
        $this->editFormElements = $elements;
    }

    public function setCreateFormElements(array $createFormElements) {
        $this->createFormElements = $createFormElements;
    }

    public function getCreateFormElements() {
        return $this->createFormElements;
    }

    public function setCreateUserAutoPassword($createUserAutoPassword) {
        $this->createUserAutoPassword = $createUserAutoPassword;
    }

    public function getCreateUserAutoPassword() {
        return $this->createUserAutoPassword;
    }

    public function getAllowPasswordChange() {
        return $this->allowPasswordChange;
    }

    public function setAllowPasswordChange($allowPasswordChange) {
        $this->allowPasswordChange = $allowPasswordChange;
    }

    public function setAutoPasswordLength($autoPasswordLength) {
        $this->autoPasswordLength = $autoPasswordLength;
    }

    public function getAutoPasswordLength() {
        return $this->autoPasswordLength;
    }

    function getTransportOptions() {
        return $this->transportOptions;
    }

    function getTransport() {
        return $this->transport;
    }

    function setTransportOptions($transportOptions) {
        $this->transportOptions = $transportOptions;
    }

    function setTransport($transport) {
        $this->transport = $transport;
    }

    function getMailFrom() {
        return $this->mailFrom;
    }

    function setMailFrom($mailFrom) {
        $this->mailFrom = $mailFrom;
    }

    function getMailTemplatePasswordRecovery() {
        return $this->mailTemplatePasswordRecovery;
    }

    function getMailTemplatePasswordSend() {
        return $this->mailTemplatePasswordSend;
    }

    function setMailTemplatePasswordRecovery($mailTemplatePasswordRecovery) {
        $this->mailTemplatePasswordRecovery = $mailTemplatePasswordRecovery;
    }

    function setMailTemplatePasswordSend($mailTemplatePasswordSend) {
        $this->mailTemplatePasswordSend = $mailTemplatePasswordSend;
    }
    
    function getMailFromName() {
        return $this->mailFromName;
    }

    function setMailFromName($mailFromName) {
        $this->mailFromName = $mailFromName;
    }




    
}
