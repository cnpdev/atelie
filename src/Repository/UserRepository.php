<?php namespace App\Repository;

use App\Entity\User;

/**
 */
class UserRepository extends EntityRepository {

	protected static $entityClass = User::class;

	/**
	 * @param string $username
	 * @return User
	 */
	public function findByUsername($username) {
		return $this->findOneBy(['username' => $username]);
	}
}
