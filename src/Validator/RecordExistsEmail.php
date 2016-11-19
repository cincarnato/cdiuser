<?php

namespace CdiUser\Validator;
use ZfcUser\Mapper\UserInterface;
use Zend\Validator\AbstractValidator;

class RecordExistsEmail extends AbstractValidator
{
    
    /**
     * Error constants
     */
    const ERROR_RECORD_NOT_FOUND = 'recordNotFound';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_RECORD_NOT_FOUND => "No existe un usuario con ese Email.",
    );

    /**
     * @var UserInterface
     */
    protected $mapper;
    
    function __construct(array $options = null) {
       // $this->mapper = $options["mapper"];
        
         parent::__construct($options);
    }

    
        /**
     * getMapper
     *
     * @return UserInterface
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * setMapper
     *
     * @param UserInterface $mapper
     * @return AbstractRecord
     */
    public function setMapper(UserInterface $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
    
        /**
     * Grab the user from the mapper
     *
     * @param string $value
     * @return mixed
     */
    protected function query($value)
    {
        $result = false;

        $result = $this->getMapper()->findByEmail($value);

        return $result;
    }
    
    public function isValid($value, $context = null)
    {
        $valid = true;
        $this->setValue($value);

        /** @var $result \ZfcUser\Entity\UserInterface|null */
        $result = $this->query($value);
        if (!$result) {
            $valid = false;
            $this->error(self::ERROR_RECORD_NOT_FOUND);
        }

        return $valid;
    }
}
