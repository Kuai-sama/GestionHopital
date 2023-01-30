<?php

namespace App\Repository;

use App\Entity\AppliquerPrescription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppliquerPrescription>
 *
 * @method AppliquerPrescription|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppliquerPrescription|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppliquerPrescription[]    findAll()
 * @method AppliquerPrescription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppliquerPrescriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppliquerPrescription::class);
    }

    public function save(AppliquerPrescription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AppliquerPrescription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function retrouverPrescription( $idPatient,  $idPrescription): array
    {
        return $this->createQueryBuilder('prescription')
            ->where('prescription.patient = '. "'$idPatient'")
            ->andWhere('prescription.Prescription = '. "'$idPrescription'")
            ->andWhere('prescription.Soignant is null')
            ->getQuery()
            ->getResult();
    }

    public function prescriptionDejaRealiser( $idPatient ): array
    {
        return $this->createQueryBuilder('prescription')
            ->leftJoin("prescription.Soignant","personne")
            ->where('prescription.patient = '. "'$idPatient'")
            ->andWhere('prescription.Soignant is not null')
            ->andWhere('personne.id = prescription.Soignant')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return AppliquerPrescription[] Returns an array of AppliquerPrescription objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AppliquerPrescription
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
