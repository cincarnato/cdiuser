<?php

namespace CdiUser\Repository;

use Doctrine\ORM\EntityRepository;

class UserLogRepository extends EntityRepository {

    public function findByUser($user) {
        return $this->getEntityManager()
                        ->createQueryBuilder()->select('u')->from('CdiUser\Entity\UserLog', 'u')
                        ->where('u.user = :user')
                        ->setParameter("user", $user)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

    
     /**
     * @save
     */
    public function save(\CdiUser\Entity\UserLog $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    /**
     * @remove
     */
    public function remove(\CdiUser\Entity\UserLog $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }
}
