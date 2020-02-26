<?php


namespace RHBundle\Repository;




use PhpOption\Tests\Repository;
use RHBundle\Entity\Classe;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class ClasseRepository extends  \Doctrine\ORM\EntityRepository
{


    /**
     * @return Classe[]
     */
    public function getClassesIncomplet()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c
            FROM RHBundle\Entity\Classe c 
            WHERE c.nbEnfantsMax > c.nbEnfants '
        );

        // returns an array of Product objects
        return $query->getResult();
    }

}