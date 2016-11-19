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

}
