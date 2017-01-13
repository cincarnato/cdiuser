<?php

namespace CdiUser\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function findByEmail($email) {
        return $this->getEntityManager()
                        ->createQueryBuilder()->select('u')->from('CdiUser\Entity\User', 'u')
                        ->where('u.email = :email')
                        ->setParameter("email", $email)
                        ->getQuery()
                        ->getOneOrNullResult();
    }
    
    
       /**
     * @save
     */
    public function save(\CdiUser\Entity\User $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    /**
     * @remove
     */
    public function remove(\CdiUser\Entity\User $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }

}
