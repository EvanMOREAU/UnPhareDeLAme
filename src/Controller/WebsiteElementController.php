<?php

namespace App\Controller;

use App\Entity\WebsiteElement;
use App\Form\WebsiteElementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/personnalisation')]
class WebsiteElementController extends AbstractController
{
    #[Route('/{id}', name: 'app_wE_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WebsiteElement $websiteElement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WebsiteElementType::class, $websiteElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edit/edit.html.twig', [
            'wE' => $websiteElement,
            'form' => $form,
        ]);
    }
}
