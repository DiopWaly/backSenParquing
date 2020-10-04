<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Repository\ChauffeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChauffeurController extends AbstractController
{
    /**
     * @Route("/chauffeur", name="chauffeur")
     */
    public function index()
    {
        return $this->render('chauffeur/index.html.twig', [
            'controller_name' => 'ChauffeurController',
        ]);
    }
    /**
     * @Route("/chauffeur/all", name="chauffeur_all", methods={"GET"})
     */
    public function getAll(ChauffeurRepository $rep){
        return $this->json($rep->findAll());
    }
    /**
     * @Route("/chauffeur/{id<[0-9]+>}", name="chauffeur_one", methods={"GET"})
     */
    public function getOne(int $id, ChauffeurRepository $rep){
        return $this->json($rep->find($id));
    }
    /**
     * @Route("/chauffeur/update/{id<[0-9]+>}", name="chauffeur_update", methods={"PUT"})
     */
    public function update(int $id, ChauffeurRepository $rep, EntityManagerInterface $emi, Request $request) : JsonResponse{

        $data = json_decode($request->getContent(), true);
        $chauffeur = $rep->find($id);
        $chauffeur->setNom($data['nom']);
        $chauffeur->setPrenom($data['prenom']);
        $chauffeur->setCivilite($data['civilite']);
        $chauffeur->setDateNaissance($data['datenaissance']);
        $chauffeur->setLieuNaissance($data['lieunaissance']);
        $chauffeur->setEmail($data['email']);
        $chauffeur->setTel($data['tel']);
        $chauffeur->setNumPermis($data['numpermis']);
        $chauffeur->setDisponibilite($data['disponibilite']);
        $emi->persist($chauffeur);
        $emi->flush();

        return new JsonResponse(['status'=>'Chauffeur updated'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/chauffeur/add", name="chauffeur_add", methods={"POST"})
     */
    public function add(ChauffeurRepository $rep, EntityManagerInterface $emi, Request $request):JsonResponse{

        $data = json_decode($request->getContent(), true);
        $chauffeur = new Chauffeur;
        $chauffeur->setNom($data['nom']);
        $chauffeur->setPrenom($data['prenom']);
        $chauffeur->setCivilite($data['civilite']);
        $chauffeur->setDateNaissance($data['datenaissance']);
        $chauffeur->setLieuNaissance($data['lieunaissance']);
        $chauffeur->setEmail($data['email']);
        $chauffeur->setTel($data['tel']);
        $chauffeur->setNumPermis($data['numpermis']);
        $chauffeur->setDisponibilite($data['disponibilite']);
        $emi->persist($chauffeur);
        $emi->flush();

        return new JsonResponse(['status'=>'Chauffeur created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/chauffeur/delete/{id<[0-9]+>}", name="chauffeur_delete", methods={"DELETE"})
     */
    public function delete(int $id, ChauffeurRepository $rep, EntityManagerInterface $emi):JsonResponse{

        $chauffeur = $rep->find($id);
        $emi->persist($chauffeur);
        $emi->flush();

        return new JsonResponse(['status'=>'Chauffeur deleted'], Response::HTTP_CREATED);
    }
}
