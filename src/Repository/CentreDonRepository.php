<?php

namespace App\Repository;

use App\Entity\CentreDon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentreDon>
 *
 * @method CentreDon|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentreDon|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentreDon[]    findAll()
 * @method CentreDon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreDonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentreDon::class);
    }
    public function findSearch(string $searchTerm): array
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.NomCentre LIKE :searchTerm')
            ->orWhere('c.DateOuverture LIKE :searchTerm')
            ->orWhere('c.datefermeture LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ;

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return CentreDon[] Returns an array of CentreDon objects
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

//    public function findOneBySomeField($value): ?CentreDon
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
