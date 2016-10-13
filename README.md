CdiUser
=======

**Que es CdiUser**

CdiUser modulo de usuarios para Zend Framework 3 y Doctrine



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
