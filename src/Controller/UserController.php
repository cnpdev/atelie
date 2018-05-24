<?php namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller {

	/**
	 * @Route("/users/{username}", name="user_show")
	 */
	public function show($username) {
	}

	/**
	 * @Route("/users/{username}/email", name="email_user")
	 */
	public function email($username) {
	}

}
