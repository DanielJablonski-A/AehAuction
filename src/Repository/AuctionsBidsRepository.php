<?php

namespace App\Repository;

use App\Entity\AuctionsBids;
use App\Helper\MoneyConverter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuctionsBids>
 *
 * @method AuctionsBids|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuctionsBids|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuctionsBids[]    findAll()
 * @method AuctionsBids[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionsBidsRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, AuctionsBids::class);
    }

    public function getAuctionMaxBid($auctionId) : int
    {
        try {
            $query = $this->entityManager->createQuery('SELECT MAX(b.currentBidPriceNet) as highestBidPrice FROM App\Entity\AuctionsBids b WHERE b.auction = :auctionId');
            $query->setParameter('auctionId', $auctionId);
            $result = $query->getSingleScalarResult();
            if ($result != null) {
                return ($result);
            } else {
                return 0;
            }
        } catch (NonUniqueResultException) {
            return 0;
        } catch (\Exception $e) {
            throw new \RuntimeException("Nie można pobrać licytowanej kwoty: " . $e->getMessage());
        }
    }

//    /**
//     * @return AuctionsBids[] Returns an array of AuctionsBids objects
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

//    public function findOneBySomeField($value): ?AuctionsBids
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
