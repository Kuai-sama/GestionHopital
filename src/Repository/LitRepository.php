<?php

namespace App\Repository;

use App\Entity\Lit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Lit>
 *
 * @method Lit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lit[]    findAll()
 * @method Lit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lit::class);
    }

    public function save(Lit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function leftJoinSalle(QueryBuilder $queryBuilder)
    {
        $queryBuilder->leftJoin('l.salle', 's')
            ->addSelect('s');
    }


    public function findAllWithSalle(): mixed
    {
        $queryBuilder = $this->createQueryBuilder('l');
        $this->leftJoinSalle($queryBuilder);
        return $queryBuilder->getQuery()
            ->getResult();
    }


    public function findAllWithSalleAndPaging(int $currentPage, int $nbPerPage): mixed
    {
        $queryBuilder = $this->createQueryBuilder('l');
        $this->leftJoinSalle($queryBuilder);
        $queryBuilder->setFirstResult(($currentPage - 1) * $nbPerPage) // Premier élément de la page
            ->setMaxResults($nbPerPage);

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function findSalleAssos(int $lit): mixed
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->leftJoin('l.salle', 's')
            ->where('l.id ='."'$lit'")
            ->andwhere('l.salle = s.id')
            ->Select('s.NomSalle');
        return $queryBuilder->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Lit[] Returns an array of Lit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Lit
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}