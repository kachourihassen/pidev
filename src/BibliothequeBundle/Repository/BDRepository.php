<?php

namespace BibliothequeBundle\Repository;

/**
 * BDRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BDRepository extends \Doctrine\ORM\EntityRepository
{
    public function getBdByDate(){
        return $this->createQueryBuilder('bd')
            ->where('bd.endDateEmprunt < CURRENT_DATE()')
            ->getQuery()->getResult();
    }
}
