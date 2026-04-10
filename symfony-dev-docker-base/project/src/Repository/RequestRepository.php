<?php

namespace App\Repository;

use App\Entity\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Request>
 */
class RequestRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Request::class);
	}

	/**
	 * @return Request[] Returns an array of Request objects
	 */
	public function findByUUID($value): array
	{
		return $this->createQueryBuilder('r')
			->andWhere('r.UUID = :val')
			->setParameter('val', $value)
			->orderBy('r.id', 'ASC')
			->getQuery()
			->getResult()
		;
	}

	public function selectNullUUID(): array
	{
		return $this->createQueryBuilder('r')
			->andWhere('r.UUID IS NULL')
			->groupBy('r.email')
			->getQuery()
			->getResult()
		;
	}

	public function updateNullUUID($UUID, $email, $code): int
    {
        return $this->createQueryBuilder('r')
            ->update('App\Entity\Request', 'r')
            ->set('r.UUID', ':UUID')
            ->setParameter('UUID', $UUID)
            ->set('r.code_mail', ':code')
            ->setParameter('code', $code)
            ->andWhere('r.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->execute()
        ;
    }

	public function selectGroupByUUID(): array
	{
		return $this->createQueryBuilder('r')
			->groupBy('r.UUID')
			->getQuery()
			->getResult()
		;
	}

	public function acceptRequest($id): int
	{
		$accepted='accepted';
		return $this->createQueryBuilder('r')
		->update('App\\Entity\\Request', 'r')
		->set('r.status',':accepted')
		->setParameter('accepted',$accepted)
		->andWhere('r.id = :ID')
		->setParameter('ID',$id)
		->getQuery()
		->execute()
		;
	}

	//    public function findOneBySomeField($value): ?Request
	//    {
	//        return $this->createQueryBuilder('r')
	//            ->andWhere('r.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->getQuery()
	//            ->getOneOrNullResult()
	//        ;
	//    }
}
