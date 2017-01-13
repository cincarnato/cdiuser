<?php

namespace CdiUser\Repository;

use Doctrine\ORM\EntityRepository;

class UserLogDetailRepository extends EntityRepository {

    public function findByUser($user) {
        return $this->getEntityManager()
                        ->createQueryBuilder()->select('u')->from('CdiUser\Entity\UserLogDetail', 'u')
                        ->where('u.user = :user')
                        ->setParameter("user", $user)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    
     /**
     * @save
     */
    public function save(\CdiUser\Entity\UserLogDetail $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    /**
     * @remove
     */
    public function remove(\CdiUser\Entity\UserLogDetail $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }
}
