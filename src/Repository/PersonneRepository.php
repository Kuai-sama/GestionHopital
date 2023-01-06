<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    public function save(Personne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Personne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPersonneByIdHoraire(int $idPersonne){
        $qb = $this->createQueryBuilder('p')
            ->where('p.id', $idPersonne);


        return $qb->getQuery()->getResult();
    }

    public function AddPersoDiagno(int $idPersonne, int $idDiagno){
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.Diagnostiquer','perDia')
        ->add('perDia.personne_id',$idPersonne)
            ->add('perDia.diagnostic_id',$idDiagno);


        return $qb->getQuery()->getResult();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Personne) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function PersonneMedecin() : array
    {
        return $this->createQueryBuilder('medecin')
            ->andWhere('medecin.roles like :val')
            ->setParameter('val', '%ROLE_MEDECIN%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function PersonneInfirmier() : array
    {
        return $this->createQueryBuilder('infirmier')
            ->andWhere('infirmier.roles like :val')
            ->setParameter('val', '%ROLE_INFIRMIER%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function PersonnePharmacien() : array
    {
        return $this->createQueryBuilder('pharmacien')
            ->andWhere('pharmacien.roles like :val')
            ->setParameter('val', '%ROLE_Pharmacien%')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Personne[] Returns an array of Personne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Personne
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
