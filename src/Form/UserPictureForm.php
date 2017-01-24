<?php

namespace CdiUser\Form;

use Zend\Form\Form;

class UserPictureForm extends Form {

    public function __construct() {
        parent::__construct('UserPictureForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => 'picture',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'required' => false,
                'placeholder' => 'Picture'
            ),
            'options' => array(
                'label' => '',
                'description' => "Subir imagen de perfil"
            )
        ));


        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'Zend\Form\Element\Submit',
            'options' => array(
                'label' => 'Enviar',
            ),
            'attributes' => array(
                'value' => "Enviar",
                'class' => 'btn btn-primary'
            )
        ));
    }

    public function inputFilter() {

        $inputFilter = new \Zend\InputFilter\InputFilter();
        $factory = new \Zend\InputFilter\Factory();

        $path = __DIR__ . "/../../../../../public/media/user/";

        $inputFilter->add($factory->createInput(array(
                    'name' => 'picture',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'filerenameupload',
                            "options" =>
                            [
                                "target" => $path,
                                "randomize" => true,
                                "use_upload_extension" => true,
//                                "use_upload_name" => 0,
//                                "overwrite" => 0
                            ]
                        ),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'FileSize',
                            'options' => array(
                                'max' => "2MB",
                            ),
                        ),
                        array(
                            'name' => 'FileMimeType',
                            'options' => array(
                                'image/gif', 'image/jpg', 'image/png', 'image/jpeg'
                            ),
                        ),
                        array(
                            'name' => 'FileImageSize',
                            'options' => array(
                                'maxWidth' => 640, 'maxHeight' => 480,
                            ),
                        ),
                    ),
        )));

        return $inputFilter;
    }

    protected function addCsrf() {
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));
    }

}
