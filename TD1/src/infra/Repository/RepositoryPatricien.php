<?php

namespace toubeelib\praticien\infra\Repository;

use Doctrine\ORM\EntityRepository;
use toubeelib\praticien\core\RepositoryInterface\InterfaceRepositoryPatricien;

class RepositoryPatricien extends EntityRepository implements InterfaceRepositoryPatricien
{
    public function findBySpecialtyKeyword(string $keyword)
    {
        $dql = "SELECT p FROM toubeelib\praticien\core\Domaine\Entity\Praticien p 
                JOIN p.specialite s 
                WHERE s.libelle LIKE :keyword OR s.description LIKE :keyword";
        
        return $this->getEntityManager()->createQuery($dql)
                    ->setParameter('keyword', '%' . $keyword . '%')
                    ->getResult();
    }

    public function findBySpecialtyAndPayment(int $specialiteId, string $moyenPaiement)
    {
        $dql = "SELECT p FROM toubeelib\praticien\core\Domaine\Entity\Praticien p 
                JOIN p.specialite s 
                JOIN p.moyensPaiement mp 
                WHERE s.id = :specialiteId AND mp.libelle = :moyenPaiement";
        
        return $this->getEntityManager()->createQuery($dql)
                    ->setParameter('specialiteId', $specialiteId)
                    ->setParameter('moyenPaiement', $moyenPaiement)
                    ->getResult();
    }
}
