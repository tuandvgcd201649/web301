<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    
    

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searching($search): Query
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('p')
            ->from('App:Product', 'p');
        if (!(is_null($search) || empty($search))) {
            $qb->andWhere('p.Name LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        // returns an array of Product objects
        return $qb->getQuery();
    }

    public function findMore($minPrice, $maxPrice, $cat): Query
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('p')
            ->from('App:Product', 'p');
        if (is_null($minPrice) || empty($minPrice)) {
            $minPrice = 0;
        }
        $qb->where('p.Price >=' . $minPrice);
        if (!(is_null($maxPrice) || empty($maxPrice))) {
            $qb->andWhere('p.Price <=' . $maxPrice);
        }
        
        if (!(is_null($cat) || empty($cat))) {
            $qb->andWhere('p.Category =' . $cat);
        }

        
        // if (!(is_null($search) || empty($search))) {
        // $qb->andWhere('p.Category LIKE :search')
        // ->setParameter('search', '%'.$search.'%');
        // }
        //add test share
        // returns an array of Product objects
        return $qb->getQuery();
    }

    // public function findProductByCat($cat): array
    // {
    //     $entityManager = $this->getEntityManager();
    //     $qb = $entityManager->createQueryBuilder();
    //     $qb->select('p')
    //         ->from('App:Product', 'p')
    //         ->where('p.Category =' . $cat);
    //     // returns an array of Product objects
    //     return $qb->getQuery()->getResult();
    // }

    //    /**
    //     * @return Product[] Returns an array of Product objects
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

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}