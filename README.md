CdiUser
=======

**Que es CdiUser**

CdiUser es un modulo que trabaja junto a ZfcUser, ZfcUserDoctrineORM and BjyAuthorize.
Se agrega administracion de usuarios


Instalacion
============

Installation via composer, agregar a composer.json:
```
"require" : {
    "cdi/cdiuser": "^3.0.0"
}
```

Cargar ```CdiUser``` **despues** de ```ZfcUser``` and ```BjyAuthorize```. Un ejemplo:

```
'modules' => array(
    'Application',
    'DoctrineModule',
    'DoctrineORMModule',
    'ZfcBase',
    'ZfcUser',
    'ZfcUserDoctrineORM',
    'BjyAuthorize',
    'CdiUser'             
)
```


Dependencias
============

 - ZfcUser
 - DoctrineORMModule
 - ZfcUserDoctrineORM
 - BjyAuthorize
