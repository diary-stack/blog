<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    //    /**
    //     * @return Articles[] Returns an array of Articles objects
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

    //    public function findOneBySomeField($value): ?Articles
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findHomeData(): array
    {
        return $this->createQueryBuilder("a")
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(11)
            ->getQuery()
            ->getResult();
    }

    public function findArticleByPage(int $page): array
    {
        $limit = 20;
        $offset = ($page - 1) * $limit;

        return $this->createQueryBuilder("a")
            ->orderBy("a.id", "DESC")
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function searchArticle(?string $keyWord = null, ?int $category = null): array
    {
        $query = $this->createQueryBuilder("a");
        $query->orderBy("a.id", "DESC");

        if ($keyWord != null) {
            $query->andWhere("MATCH_AGAINST(a.title, a.content) AGAINST (:keyWord boolean)>0")
                ->setParameter("keyWord", $keyWord);
        }

        if ($category != null) {
            $query->leftJoin("a.category", "c");
            $query->andWhere("c.id = :id")
                ->setParameter("id", $category);
        }

        return $query->getQuery()->getResult();
    }
}
