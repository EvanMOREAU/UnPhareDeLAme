<?php

namespace App\Controller;

use App\Entity\Consultant;
use App\Entity\ConsultantData;
use App\Form\ConsultantDataType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConsultantDataRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/consultant')]
class ConsultantController extends AbstractController
{
    #[Route('/{id}', name: 'app_consultant', methods: ['GET', 'POST'])]
    public function index(Request $request, Consultant $consultant, ConsultantDataRepository $consultantDataRepository, EntityManagerInterface $entityManager): Response
    {
        $newConsultantData = new ConsultantData();
        $formNewConsultantData = $this->createForm(ConsultantDataType::class, $newConsultantData);
        $formNewConsultantData->handleRequest($request);

        if ($formNewConsultantData->isSubmitted() && $formNewConsultantData->isValid()) {
            $newConsultantData->setConsultant($consultant);
            $entityManager->persist($newConsultantData);
            $entityManager->flush();
        
            return $this->redirectToRoute('app_consultant', ['id' => $consultant->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consultant/index.html.twig', [
            'controller_name' => 'ConsultantController',
            'consultant' => $consultant,
            'formNewConsultantData' => $formNewConsultantData,
            'ConsultantDatas' => $consultantDataRepository->findByConsultant($consultant->getId()),
        ]);
    }
    #[Route('/delete/{id}', name: 'delete_consultant_data', methods: ['POST'])]
    public function delete(ConsultantData $consultantData, EntityManagerInterface $entityManager): Response
    {
        $consultantId = $consultantData->getConsultant()->getId();
        
        $entityManager->remove($consultantData);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_consultant', ['id' => $consultantId]);
    }
    #[Route('/delete-consultant/{id}', name: 'delete_consultant', methods: ['POST'])]
    public function deleteConsultant(Request $request, Consultant $consultant, EntityManagerInterface $entityManager): Response
    {
        // Supprimer toutes les données liées au consultant

        if ($this->isCsrfTokenValid('delete'.$consultant->getId(), $request->request->get('_token'))) {
            foreach ($consultant->getConsultantData() as $consultantData) {
                $entityManager->remove($consultantData);
            }
            $entityManager->remove($consultant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
