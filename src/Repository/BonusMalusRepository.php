<?php

namespace App\Repository;

use App\Entity\BonusMalus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BonusMalus>
 *
 * @method BonusMalus|null find($id, $lockMode = null, $lockVersion = null)
 * @method BonusMalus|null findOneBy(array $criteria, array $orderBy = null)
 * @method BonusMalus[]    findAll()
 * @method BonusMalus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonusMalusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonusMalus::class);
    }

    public function add(BonusMalus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BonusMalus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Busca aquellos registros cuyo monto sea menor o igual que el valor pasado como parámetro.
     *
     * Este metodo permite buscar los registros correspondientes a "Malus", es decir,
     * aquellas multas por exceso de emision de CO2 ya que estos registros tienen monto
     * negativo.
     *
     * @return BonusMalus[] Returns an array of BonusMalus objects
     */
    public function findByMontantLessOrEqualThan($value = 0): array
    {
        return $this->createQueryBuilder('bm')
            ->andWhere('bm.montant <= :val')
            ->setParameter('val', $value)
            ->orderBy('bm.minCO2', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Busca aquellos registros cuyo monto sea mayor o igual que el valor pasado como parámetro.
     *
     * Este metodo permite buscar los registros correspondientes a "Bonus", es decir,
     * aquellos descuentos por reducción de emision de CO2 ya que dichos registros tienen monto mayor a 0
     *
     * @return BonusMalus[] Returns an array of BonusMalus objects
     */
    public function findByMontantGreatherOrEqualThan($value = 0): array
    {
        return $this->createQueryBuilder('bm')
            ->andWhere('bm.montant >= :val')
            ->setParameter('val', $value)
            ->orderBy('bm.minCO2', 'ASC')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return BonusMalus[] Returns an array of BonusMalus objects
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

//    public function findOneBySomeField($value): ?BonusMalus
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
