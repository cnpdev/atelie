<?php namespace App\Repository;

use App\Entity\Entity;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EntityRepository extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository {

	protected static $entityClass = Entity::class;

	public function __construct(RegistryInterface $registry) {
		parent::__construct($registry, static::$entityClass);
	}

}
