<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function save(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAttrsByString(string $search_string): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
        'SELECT *
            FROM contact c
            WHERE c.name LIKE :search_string
            OR c.secondname LIKE :search_string
            OR c.note LIKE :search_string
            OR c.phone LIKE :search_string
            OR c.email LIKE :search_string
            ORDER BY c.name ASC, c.secondname ASC'
        )->setParameter('search_string', $search_string);

        return $query->getResult();
    }

//    public function findAttrsByString(string $search_string): array // the SQL case
//    {
//        $conn = $this->getEntityManager()->getConnection();
//
//        $sql = '
//            SELECT *
//            FROM contact c
//            WHERE c.name LIKE :search_string
//            OR c.secondname LIKE :search_string
//            OR c.note LIKE :search_string
//            OR c.phone LIKE :search_string
//            OR c.email LIKE :search_string
//            ORDER BY c.name ASC, c.secondname ASC
//        ';
//        $stmt = $conn->prepare($sql);
//        $resultSet = $stmt->executeQuery(['search_string' => '%'.$search_string.'%']);
//
//        // returns an array of arrays (i.e. a raw data set)
//        return $resultSet->fetchAllAssociative();
//
//    }



    /**
     * @return Contact[] Returns an array of Contact objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name LIKE :val')
            ->orWhere('c.secondname LIKE :val')
            ->orWhere('c.note LIKE :val')
            ->orWhere('c.phone LIKE :val')
            ->orWhere('c.email LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(null)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Contact
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
