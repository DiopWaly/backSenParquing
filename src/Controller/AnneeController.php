<?php

namespace App\Controller;

use App\Entity\Annee;
use App\Repository\AnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnneeController extends AbstractController
{
    /**
     * @Route("/annee", name="annee")
     */
    public function index()
    {
        return $this->render('annee/index.html.twig', [
            'controller_name' => 'AnneeController',
        ]);
    }
    /**
     * @Route("/annee/all", name="annee_all", methods={"GET"})
     */
    public function getall(AnneeRepository $rep){
        $data = $rep->findAll();
        return $this->json($data);
    }
    /**
     * @Route("/annee/{id<[0-9]+>}", name="annee_one", methods={"GET"})
     */
    public function getone(int $id, AnneeRepository $rep){
        $data = $rep->find($id);
        return $this->json($data);
    }
    /**
     * @Route("/annee/add", name="annee_add", methods={"POST"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function add(EntityManagerInterface $emi, Request $request) : JsonResponse{
        $data = json_decode($request->getContent(), true);
        $annee = new Annee;
        $annee->setAnnee($data['annee']);
        $emi->persist($annee);
        $emi->flush();
        return new JsonResponse(['status'=>'annee created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/annee/update/{id<[0-9]+>}", name="annee_update", methods={"PUT"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function update(int $id, AnneeRepository $rep, EntityManagerInterface $emi, Request $request) : JsonResponse{
        $data = json_decode($request->getContent(), true);
        $annee = $rep->find($id);
        $annee->setAnnee($data['annee']);
        $emi->persist($annee);
        $emi->flush();
        return new JsonResponse(['status'=>'annee modifier'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/annee/delete/{id<[0-9]+>}", name="annee_delete", methods={"DELETE"})
     * @return JsonResponse
     */
    public function delete(int $id, AnneeRepository $rep, EntityManagerInterface $emi) : JsonResponse{
        // $data = json_decode($request->getContent(), true);
        $annee = $rep->find($id);
        $emi->remove($annee);
        $emi->flush();
        return new JsonResponse(['status'=>'annee deleted'], Response::HTTP_CREATED);
    }
}
