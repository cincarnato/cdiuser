<?php

namespace CdiUser\Repository;

use Doctrine\ORM\EntityRepository;

class UserPictureRepository extends EntityRepository {

    public function save(\CdiUser\Entity\UserPicture $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(\CdiUser\Entity\UserPicture $entity) {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

}
