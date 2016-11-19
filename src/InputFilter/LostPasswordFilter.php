<?php

namespace CdiUser\InputFilter;

use CdiUser\InputFilter\ProvidesEventsInputFilter;


class LostPasswordFilter extends ProvidesEventsInputFilter
{
    protected $emailValidator;


    public function __construct($emailValidator)
    {
        $this->emailValidator = $emailValidator;
      
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
                $this->emailValidator
            ),
        ));


        $this->getEventManager()->trigger('init', $this);
    }

    public function getEmailValidator()
    {
        return $this->emailValidator;
    }

    public function setEmailValidator($emailValidator)
    {
        $this->emailValidator = $emailValidator;
        return $this;
    }


}
