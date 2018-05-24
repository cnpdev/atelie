<?php namespace App\Listener;

use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class KernelListener implements EventSubscriberInterface {

	public static function getSubscribedEvents() {
		return [
			KernelEvents::REQUEST => 'onKernelRequest',
#			KernelEvents::EXCEPTION => 'onKernelException',
		];
	}

	private $userRepository;
	private $tokenStorage;
	private $singleLoginProvider;
	private $twig;

	public function __construct(UserRepository $userRepository, TokenStorageInterface $tokenStorage, ?string $singleLoginProvider, \Twig_Environment $twig) {
		$this->userRepository = $userRepository;
		$this->tokenStorage = $tokenStorage;
		$this->singleLoginProvider = $singleLoginProvider;
		$this->twig = $twig;
	}

	/**
	 * @param GetResponseEvent $event
	 */
	public function onKernelRequest(GetResponseEvent $event) {
		if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
			return;
		}
		$this->initTokenStorage();
	}

//	public function onKernelException(GetResponseForExceptionEvent $event) {
//		$exception = $event->getException();
//		$statusCode = $exception instanceof HttpException ? $exception->getStatusCode() : ($exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
//		$response = new Response($this->twig->render('exception.html.twig', ['exception' => $exception]), $statusCode);
//		$event->setResponse($response);
//	}

	private function initTokenStorage() {
		if (!$this->singleLoginProvider) {
			return;
		}
		$chitankaUser = (require $this->singleLoginProvider)();
		if ($chitankaUser['username']) {
			$user = $this->userRepository->findByUsername($chitankaUser['username']);
			if (!$user) {
				$user = $this->userRepository->createUser($chitankaUser['username'], $chitankaUser['email']);
			}
			$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, null, 'User', $user->getRoles());
			$this->tokenStorage->setToken($token);
		}
	}

}
