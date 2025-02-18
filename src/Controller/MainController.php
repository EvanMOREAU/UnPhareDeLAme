<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Form\UserType;
use App\Entity\Parcour;
use App\Entity\Service;
use App\Form\ParcourType;
use App\Form\ServiceType;
use App\Entity\Consultant;
use App\Form\Service1Type;
use App\Form\ConsultantType;
use App\Form\ServiceEditType;
use App\Repository\TypeRepository;
use App\Repository\ParcourRepository;
use App\Repository\ServiceRepository;
use App\Services\ImageUploaderHelper;
use App\Repository\ConsultantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\ConsultantDataRepository;
use App\Repository\WebsiteElementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/')]
class MainController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    #[Route('', name: 'app_main')]
    public function index(
        Request $request,
        ServiceRepository $serviceRepository,
        ParcourRepository $parcourRepository,
        TypeRepository $typeRepository,
        EntityManagerInterface $entityManager,
        ImageUploaderHelper $imageUploaderHelper,
        Security $security,
        WebsiteElementRepository $websiteElementRepository,
        ConsultantRepository $consultantRepository,
        ConsultantDataRepository $consultantDataRepository
    ): Response {
        // Création d'un nouveau service
        $user = $security->getUser();

        $formPassword = $this->createForm(UserType::class, $user);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {

            $cp = $formPassword->get('currentPassword')->getData();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $cp
            );
            if($hashedPassword == $user->getPassword()){
                $np = $formPassword->get('password')->getData();
                $hashedNewPassword = $this->passwordHasher->hashPassword(
                    $user,
                    $np
                );
                $user->setPassword($hashedNewPassword);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        $newService = new Service();
        $formNewService = $this->createForm(ServiceType::class, $newService);
        $formNewService->handleRequest($request);

        if ($formNewService->isSubmitted() && $formNewService->isValid()) {
            $imageFile = $formNewService->get('img')->getData();
        
            if ($imageFile) {
                try {
                    // Appeler la méthode uploadImage pour obtenir le nom du fichier final
                    $newFilename = $imageUploaderHelper->uploadImage($imageFile, $newService->getName());
                    if ($newFilename) {
                        $newService->setImg($newFilename); // Enregistrer seulement le nom du fichier dans l'entité
                    }
                } catch (\Exception $e) {
                    $this->addFlash('danger', $e->getMessage());
                }
            }
        
            $entityManager->persist($newService);
            $entityManager->flush();
        
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        // Récupérer tous les services
        $services = $serviceRepository->findAll();
               
        
        // Création d'un nouveau type
        $type = new Type();
        $formNewType = $this->createForm(TypeType::class, $type);
        $formNewType->handleRequest($request);

        if ($formNewType->isSubmitted() && $formNewType->isValid()) {
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }
        // Création d'un nouveau consultant
        $consultant = new Consultant();
        $formNewConsultant = $this->createForm(ConsultantType::class, $consultant);
        $formNewConsultant->handleRequest($request);

        if ($formNewConsultant->isSubmitted() && $formNewConsultant->isValid()) {
            $entityManager->persist($consultant);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        // Récupérer tous les types
        $types = $typeRepository->findAll();
       
        $parcour = new Parcour();
        $formParcour = $this->createForm(ParcourType::class, $parcour);
        $formParcour->handleRequest($request);

        if ($formParcour->isSubmitted() && $formParcour->isValid()) {
            $imageFile = $formParcour->get('img')->getData();
        
            if ($imageFile) {
                try {
                    // Appeler la méthode uploadImage pour obtenir le nom du fichier final
                    $newFilename = $imageUploaderHelper->uploadImage($imageFile, $parcour->getTitle());
                    
                    if ($newFilename) {
                        $parcour->setImg($newFilename); // Enregistrer seulement le nom du fichier dans l'entité
                    }
                } catch (\Exception $e) {
                    $this->addFlash('danger', $e->getMessage());
                }
            }
            $entityManager->persist($parcour);
            $entityManager->flush();

            return $this->redirectToRoute('app_parcour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'services' => $services,
            'types' => $types,
            'parcours' => $parcourRepository->findAll(),
            'formNewService' => $formNewService->createView(),
            'formNewType' => $formNewType->createView(),
            'formNewParcour' => $formParcour,
            'formPassword' => $formPassword,
            'formNewConsultant' => $formNewConsultant,
            'Consultants' => $consultantRepository->findAll(),
            'ConsultantsDatas' => $consultantDataRepository->findAll(),
            'wE' => $websiteElementRepository->findAll(),
        ]);
    }

    #[Route('/service/delete/{id}', name: 'app_main_service_delete', methods: ['POST'])]
    public function deleteService(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route('/type/delete/{id}', name: 'app_main_type_delete', methods: ['POST'])]
    public function deleteType(Request $request, Type $type, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/parcour/delete/{id}', name: 'app_main_parcour_delete', methods: ['POST'])]
    public function deleteParcour(Request $request, Parcour $parcour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parcour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
