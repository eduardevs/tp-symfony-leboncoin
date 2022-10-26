<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Post[] Returns an array of Post objects
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

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function searchElementsWithForm( $date = null, $prices = null , $category = null): array
    {
        $query  = $this->createQueryBuilder('p');

        if (!\is_null($category)) {
            $query->leftJoin('p.category', 'cat')
            ->addSelect('cat')
            ->andWhere('cat.id = :category')
            ->setParameter('category', $category);
        } 

        if (!\is_null($prices)) {
            $query->andWhere('p.price <= :prices')
            ->setParameter('prices', $prices);
        } 

        if (!\is_null($date)) {
            $query->andWhere("p.date >= :date")
            ->setParameter('date', $date);
        }
 
        return $query
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
        }



    public function searchElementsWithFormCategoryM($category): array
        {
            return $this->createQueryBuilder('post')
            ->innerJoin('post.category', 'cat')
            ->addSelect('cat')
            ->where('cat.id = :category_id')
            ->setParameter('category_id', $category)
            ->getQuery()
            ->getResult();
        }



    public function protection($category): array
      {
        return $this->createQueryBuilder('p')
            // ->andWhere('p.price <= :prices')
            // ->setParameter('prices', $prices)

            // Pour joindre la table catégorie
            // ->leftJoin('p.category', 'cat')
            // ->addSelect('cat')
            // ->andWhere('cat.id = :category')
            // ->setParameter('category', $category)

            // ->andWhere("p.date > :date")
            // ->setParameter('date', $date)

            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
