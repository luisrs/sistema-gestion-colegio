<?php

namespace App\Repository;

use App\Entity\ArchivoCargaMasiva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArchivoCargaMasiva>
 *
 * @method ArchivoCargaMasiva|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchivoCargaMasiva|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchivoCargaMasiva[]    findAll()
 * @method ArchivoCargaMasiva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchivoCargaMasivaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchivoCargaMasiva::class);
    }

    public function save(ArchivoCargaMasiva $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArchivoCargaMasiva $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ArchivoCargaMasiva[] Returns an array of ArchivoCargaMasiva objects
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

//    public function findOneBySomeField($value): ?ArchivoCargaMasiva
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
