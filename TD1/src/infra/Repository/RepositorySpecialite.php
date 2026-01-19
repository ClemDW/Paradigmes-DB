<?php

namespace toubeelib\praticien\infra\Repository;

use Doctrine\ORM\EntityRepository;

class RepositorySpecialite extends EntityRepository
{
    public function findByKeyword(string $keyword)
    {
        $dql = "SELECT s FROM toubeelib\praticien\core\Domaine\Entity\Specialite s 
                WHERE s.libelle LIKE :keyword OR s.description LIKE :keyword";
        
        return $this->getEntityManager()->createQuery($dql)
                    ->setParameter('keyword', '%' . $keyword . '%')
                    ->getResult();
    }
}
