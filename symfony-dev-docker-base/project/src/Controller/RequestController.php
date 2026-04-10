<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\RequestType;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as httprequest;

final class RequestController extends AbstractController
{
	#[Route('/accueil', name: 'app_request_index')]
	public function index(RequestRepository $repo): Response
	{
		foreach ($repo->selectNullUUID() as $r) {
			$r->setUUID($r->getEmail());
			$repo->updateNullUUID($r->getUUID(), $r->getEmail());
		}
		$uniRequests = $repo->selectGroupByUUID();
		return $this->render('request/index.html.twig', [
			'controller_name' => 'RequestController',
			'requests' => $uniRequests,
		]);
	}

	#[Route('/{UUID}/accept', name: 'app_request_accept', methods: ['POST'])]
public function accept(
    #[MapEntity(mapping: ['UUID' => 'UUID'])] Request $request,
    EntityManagerInterface $entityManager,
    httprequest $http, RequestRepository $repo
): Response {
    if ($this->isCsrfTokenValid('accept' . $request->getId(), $http->getPayload()->getString('_token'))) {
			$repo->acceptRequest($request->getId()); 
		}

    return $this->redirectToRoute('app_request_show', ['UUID' => $request->getUuid()], Response::HTTP_SEE_OTHER);
}


	#[Route('/new', name: 'app_request_new', methods: ['GET', 'POST'])]
	public function new( EntityManagerInterface $entityManager, httprequest $http): Response
	{
		$request = new Request();
		$form = $this->createForm(RequestType::class, $request);
		$form->handleRequest($http);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($request);
			$entityManager->flush();

			return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->render('request/new.html.twig', [
			'request' => $request,
			'form' => $form,
		]);
	}

		#[Route('/accueil/{UUID}', name: 'app_request_show', methods: ['GET'])]
	public function show(
		#[MapEntity(mapping: ['UUID' => 'UUID'])] Request $request
	): Response {
		return $this->render('request/show.html.twig', [
			'request' => $request,
		]);
	}
 
	#[Route('/{UUID}/edit', name: 'app_request_edit', methods: ['GET', 'POST'])]
	public function edit(
		#[MapEntity(mapping: ['UUID' => 'UUID'])] Request $request,
		EntityManagerInterface $entityManager,
		httprequest $http
	): Response {
		$form = $this->createForm(RequestType::class, $request);
		$form->handleRequest($http);
 
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->flush();
 
			return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
		}
 
		return $this->render('request/edit.html.twig', [
			'request' => $request,
			'form' => $form,
		]);
	}
 
	#[Route('/{UUID}', name: 'app_request_delete', methods: ['POST'])]
	public function delete(
		#[MapEntity(mapping: ['UUID' => 'UUID'])] Request $request,
		EntityManagerInterface $entityManager,
		httprequest $http
	): Response {
		if ($this->isCsrfTokenValid('delete' . $request->getId(), $http->getPayload()->getString('_token'))) {
			$entityManager->remove($request);
			$entityManager->flush();
		}
 
		return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);
	}
}
