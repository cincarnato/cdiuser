CdiUser
=======

**Que es CdiUser**

CdiUser modulo de usuarios para Zend Framework 3 y Doctrine

La mayor parte del modulo esta basada en el modulo de Danielss89: https://github.com/Danielss89/ZfcUserAdmin.git

Instalacion
============

Installation via composer, agregar a composer.json:
```
"require" : {
    "cdi/cdiuser": "^3.0.0"
}
```

Cargar ```CdiUser``` **despues** de ```ZfcUser``` . Un ejemplo:

```
'modules' => array(
    
    'DoctrineModule',
    'DoctrineORMModule',
    'ZfcUser',
    'ZfcUserDoctrineORM',
    'CdiUser'
    'Application',        
)
```


Dependencias
============

 - ZfcUser
 - ZfcUserDoctrineORM
 - DoctrineORMModule
