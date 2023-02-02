<?php

namespace App\Repository;

use App\Entity\RDV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RDV>
 *
 * @method RDV|null find($id, $lockMode = null, $lockVersion = null)
 * @method RDV|null findOneBy(array $criteria, array $orderBy = null)
 * @method RDV[]    findAll()
 * @method RDV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RDVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RDV::class);
    }

    public function save(RDV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RDV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findValiderRDVByDate($date): mixed
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->Where('r.DateHeure LIKE :date')
            ->setParameter('date', $date . '%')
            ->andWhere('r.valider = 1');
        return $queryBuilder->getQuery()->getResult();
    }

    # Récupérer les rendez-vous validés liés à un médecin
    public function findValideRDVByMedecinOuInfermier($id): mixed
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->Where('r.Personne2 =' . "'$id'")
            ->andWhere('r.valider = 1');

        return $queryBuilder->getQuery()->getResult();
    }
    # Récupérer tous les rendez-vous liés à un médecin
    public function findRDVByMedecinOuInfermier($id): mixed
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->Where('r.Personne2 =' . "'$id'");

        return $queryBuilder->getQuery()->getResult();
    }

    //    /**
    //     * @return RDV[] Returns an array of RDV objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RDV
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}