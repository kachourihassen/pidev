<?php

namespace ActiviteBundle\Repository;

/**
 * ActiviteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActiviteRepository extends \Doctrine\ORM\EntityRepository
{
    function findName($nom){
        $query=$this->getEntityManager()
            ->createQuery("select c from ActiviteBundle:Activite c where c.categorie like'%".$nom."%'
         or c.nom like'%".$nom."%'  or c.description like'%".$nom."%' 
                       or  c.prix like'%".$nom."%' ");
           // ->setParameter('n','%'.$nom.'%');
        return $query->getResult();
    }

}
