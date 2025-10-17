<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\GardenType; // ← Correct namespace
use App\Entity\GardenMariemFerchichi;
use App\Repository\GardenMariemFerchichiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
final class GardenMariemFerchichiController extends AbstractController
{
    #[Route('/garden/mariem/ferchichi', name: 'app_garden_mariem_ferchichi')]
    public function index(): Response
    {
        return $this->render('garden_mariem_ferchichi/index.html.twig', [
            'controller_name' => 'GardenMariemFerchichiController',
        ]);
    }
    #[Route('/garden/mariem/ferchichi/list', name:'app_garden_mariem_ferchichi_list')]
    public function gardenlist(GardenMariemFerchichiRepository $gardenRepository): Response {
        $gardenDB= $gardenRepository->findAll();
        return $this->render('garden_mariem_ferchichi/garden.html.twig', [
            'gardens' => $gardenDB
        ]);
    }
    #[Route('/garden/mariem/ferchichi/details/{id}', name:'app_garden_mariem_ferchichi_details')]
    public function etudiantDetails($id, GardenMariemFerchichiRepository $gardenRepository): Response {
        
        $gardenDB= $gardenRepository->find($id);
        return $this->render('garden_mariem_ferchichi/details.html.twig', [
            "title" => "Garden Details",
            'garden' => $gardenDB
        ]);
    }
    #[Route('/garden/mariem/ferchichi/delete/{id}', name:'app_garden_mariem_ferchichi_delete')]
    public function deleteetudiant($id, GardenMariemFerchichiRepository $gardenRepository, EntityManagerInterface $em){
        $garden = $gardenRepository->find($id);
        $em->remove($garden);
        $em->flush();
        return $this->redirectToRoute('app_garden_mariem_ferchichi_list');
        //dd("Author Deleted");
    }
    #[Route('/garden/mariem/ferchichi/create', name:'app_garden_mariem_ferchichi_create')]
    public function createGarden(Request $request, EntityManagerInterface $em){
        $garden = new Gardenmariemferchichi();
        //$author->setUsername('Defaulttt');
        $form = $this->createForm(GardenType::class, $garden);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //dd($author);
            dump($garden);
            $em->persist($garden);
            $em->flush();
            return $this->redirectToRoute('app_garden_mariem_ferchichi_list');
        }
        return $this->render('garden_mariem_ferchichi/form.html.twig', [
            "title" => "Create new garden",
            "form" => $form
        ]);
    }
    #[Route('/garden/mariem/ferchichi/update/{id}', name:'app_garden_mariem_ferchichi_update')]
    public function updateetudiant($id, Request $request, EntityManagerInterface $em, GardenMariemFerchichiRepository $gardenRepository){
        $garden = $gardenRepository->find( $id );
        //$author->setUsername('Defaulttt');
        $form = $this->createForm(GardenType::class, $garden);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //dd($author);
            //dump($author);
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_garden_mariem_ferchichi_list');
        }
        return $this->render('garden_mariem_ferchichi/form.html.twig', [
            "title" => "update garden",
            "form" => $form
        ]);
    }
}
