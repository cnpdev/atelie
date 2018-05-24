<?php namespace App\Controller;

use App\Entity\Entry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EntryController extends Controller {

	/**
	 * @Route("/")
	 */
	public function listAction() {
		$entries = $this->getDoctrine()->getRepository(Entry::class)->findLatest(20);
		return $this->render('Entry/list.html.twig', [
			'entries' => $entries,
			'statusClasses' => [
				Entry::STATUS_0 => 'fa fa-fw fa-square-o status-plan',
				Entry::STATUS_1 => 'fa fa-fw fa-square status-scan',
				Entry::STATUS_2 => 'fa fa-fw fa-circle-o status-waiting',
				Entry::STATUS_3 => 'fa fa-fw fa-dot-circle-o status-edit',
				Entry::STATUS_4 => 'fa fa-fw fa-code status-format',
				Entry::STATUS_5 => 'fa fa-fw fa-question-circle status-forcheck',
				Entry::STATUS_6 => 'fa fa-fw fa-check-circle status-checked',
				Entry::STATUS_7 => 'fa fa-fw fa-circle status-done',
				'all' => 'fa fa-fw fa-tasks',
				'my' => 'fa fa-fw fa-user',
				'waiting' => 'fa fa-fw fa-search-plus status-waiting',
			],
		]);
	}

	/**
	 * @Route("/edit/{id}", name="entry_edit")
	 */
	public function edit(Entry $entry) {
	}

	public function latestAction($limit = 10) {
		return [
			'entries' => $this->em()->getWorkEntryRepository()->getLatest($limit),
		];
	}
}
