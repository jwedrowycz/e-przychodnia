<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\Filter\UserVisitsFilterType;
use App\Form\Filter\VisitsFilterType;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile.")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param VisitRepository $visitRepo
     * @param Request $request
     * @return Response
     */
    public function index(VisitRepository $visitRepo, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $countVisits = $visitRepo->countAllUserVisits($user);
        $visits = $visitRepo->findAllAssociatedFilter($user);
        $form = $this->createForm(UserVisitsFilterType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $clinic = $form->get('clinic')->getData();
            $clinic = empty($clinic) ? '' : $clinic->getId();

            $visitType = $form->get('type')->getData();
            $visitSort = $form->get('sort')->getData();

            $visits = $visitRepo->findAllAssociatedFilter($user, $clinic, $visitType, $visitSort);
        }
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'visits' => $visits,
            'countVisits' => $countVisits,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/visit/{id}", name="visit_show")
     * @param $id
     * @param VisitRepository $visitRepository
     * @return Response
     */
    public function show($id, VisitRepository $visitRepository)
    {
        $visit = $visitRepository->findSpecificVisit($id);
        return $this->render('profile/show.html.twig', [
            'visit' => $visit
        ]);
    }
    

    /**
     * @Route("/edit", name="profile_edit")
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Pomyślnie edytowałeś swoje dane'
            );
            return $this->redirectToRoute('profile.index');

        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    

}
