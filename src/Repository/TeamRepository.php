<?php

namespace CdiUser\Repository;

use Doctrine\ORM\EntityRepository;

class TeamRepository extends EntityRepository {

       /**
     * @save
     */
    public function save(\CdiUser\Entity\Team $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    /**
     * @remove
     */
    public function remove(\CdiUser\Entity\Team $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }
}
