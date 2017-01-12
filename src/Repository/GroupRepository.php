<?php

namespace CdiUser\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository {

       /**
     * @save
     */
    public function save(\CdiUser\Entity\Group $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    /**
     * @remove
     */
    public function remove(\CdiUser\Entity\Group $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }
}
