<?php

namespace CdiUser\Validator;


use ZfcUser\Validator\NoRecordExists;

class NoRecordExistsEdit extends NoRecordExists
{
    public function isValid($value, $context = null)
    {
        $valid = true;
        $this->setValue($value);

        /** @var $result \ZfcUser\Entity\UserInterface|null */
        $result = $this->query($value);
        if ($result && $result->getId() != $context['userId']) {
            $valid = false;
            $this->error(self::ERROR_RECORD_FOUND);
        }

        return $valid;
    }
}