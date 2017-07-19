<?php

namespace CdiUser\Mapper;

use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;

class UserDoctrine extends ZfcUserDoctrineMapper
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getUserEntityClass());
        return $er->findAll();
    }

    
    public function remove($entity)
    {
        $this->getEventManager()->trigger('remove.pre', $this, array('entity' => $entity));
        $this->em->remove($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('remove', $this, array('entity' => $entity));
    }
    
     public function save(\CdiUser\Entity\User $entity)
    {
        $this->getEventManager()->trigger('save.pre', $this, array('entity' => $entity));
        $this->em->persist($entity);
        $this->em->flush();
        $this->getEventManager()->trigger('save', $this, array('entity' => $entity));
    }
}
