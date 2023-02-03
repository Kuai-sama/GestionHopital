<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function save(Patient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Patient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPatLit(){
        $qb = $this->createQueryBuilder('pat')
            ->leftJoin("pat.Personne","per")
            ->leftJoin("per.idLit ","l")
            ->leftJoin("l.salle ","sa")
            ->select("pat","per","l","sa");


        return $qb->getQuery()->getResult();
    }

    public function getPatPer($idUS){
        $qb = $this->createQueryBuilder('pat')
            ->leftJoin("pat.Personne","per")
            ->leftJoin("pat.Service","ser")
            ->select("pat","per")
            ->where('ser.id ='."'$idUS'");


        return $qb->getQuery()->getResult();
    }

    public function getPatInfo(int $idp){
        $qb = $this->createQueryBuilder('pat')
            ->leftJoin("pat.Personne","per")
            ->leftJoin("per.Diagnostic","dia")
            ->leftJoin("per.appliquerPrescriptions","apppres")
            ->leftJoin("apppres.Prescription","pres")
            ->leftJoin("per.Diagnostiquer","diagnostiquer")
            ->select("pat","per")
            ->where('pat.id ='."'$idp'");


        return $qb->getQuery()->getResult();
    }

    /*public function getDiagnostic(int $idPatient)
    {
        $qb = $this->createQueryBuilder('patient')
            ->leftJoin("patient.Personne","personne")
            ->leftJoin("personne.Diagnostic","diagnostic") // Pour avoir l'id du diag
            ->leftJoin("personne.Diagnostiquer", "diagnostiquer")
            ->select("patient", "personne","diagnostic","diagnostiquer")
            ->where('patient.id ='."'$idPatient'")
            ->where('diagnostiquer.diagnostic_id = diagnostic.diagnostic_id');

        return $qb->getQuery()->getResult();
    }*/

//    /**
//     * @return Patient[] Returns an array of Patient objects
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

//    public function findOneBySomeField($value): ?Patient
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
