<?php

namespace App\Repository;

use App\Entity\BoiteDeVitesse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoiteDeVitesse>
 *
 * @method BoiteDeVitesse|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoiteDeVitesse|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoiteDeVitesse[]    findAll()
 * @method BoiteDeVitesse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoiteDeVitesseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoiteDeVitesse::class);
    }

    public function add(BoiteDeVitesse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BoiteDeVitesse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BoiteDeVitesse[] Returns an array of BoiteDeVitesse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BoiteDeVitesse
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
