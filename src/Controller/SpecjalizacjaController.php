<?php

namespace App\Controller;

use App\Entity\Specjalizacja;
use App\Form\SpecjalizacjaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/specjalizacja")
 */
class SpecjalizacjaController extends AbstractController
{
    /**
     * @Route("/", name="specjalizacja_index", methods={"GET"})
     */
    public function index(): Response
    {
        $specjalizacjas = $this->getDoctrine()
            ->getRepository(Specjalizacja::class)
            ->findAll();

        return $this->render('specjalizacja/index.html.twig', [
            'specjalizacjas' => $specjalizacjas,
        ]);
    }

    /**
     * @Route("/new", name="specjalizacja_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $specjalizacja = new Specjalizacja();
        $form = $this->createForm(SpecjalizacjaType::class, $specjalizacja);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($specjalizacja);
            $entityManager->flush();

            return $this->redirectToRoute('specjalizacja_index');
        }

        return $this->render('specjalizacja/new.html.twig', [
            'specjalizacja' => $specjalizacja,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specjalizacja_show", methods={"GET"})
     */
    public function show(Specjalizacja $specjalizacja): Response
    {
        return $this->render('specjalizacja/show.html.twig', [
            'specjalizacja' => $specjalizacja,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="specjalizacja_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Specjalizacja $specjalizacja): Response
    {
        $form = $this->createForm(SpecjalizacjaType::class, $specjalizacja);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specjalizacja_index');
        }

        return $this->render('specjalizacja/edit.html.twig', [
            'specjalizacja' => $specjalizacja,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specjalizacja_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Specjalizacja $specjalizacja): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specjalizacja->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($specjalizacja);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specjalizacja_index');
    }
}
