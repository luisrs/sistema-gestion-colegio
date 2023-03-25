<?php

namespace App\Repository;

use App\Entity\CursoAsignatura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CursoAsignatura>
 *
 * @method CursoAsignatura|null find($id, $lockMode = null, $lockVersion = null)
 * @method CursoAsignatura|null findOneBy(array $criteria, array $orderBy = null)
 * @method CursoAsignatura[]    findAll()
 * @method CursoAsignatura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CursoAsignaturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CursoAsignatura::class);
    }

    public function save(CursoAsignatura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CursoAsignatura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CursoAsignatura[] Returns an array of CursoAsignatura objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CursoAsignatura
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
