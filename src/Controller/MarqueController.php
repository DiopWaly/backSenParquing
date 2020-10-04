<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    /**
     * @Route("/marque", name="marque")
     */
    public function index()
    {
        return $this->render('marque/index.html.twig', [
            'controller_name' => 'MarqueController',
        ]);
    }

    /**
     * @Route("/marque/all", name="marque_all", methods={"GET"})
     * @param Requeste $requeste
     * @return JsonResponse 
     */
    public function getall(MarqueRepository $rep){
        $data = $rep->findAll();
        return $this->json($data);
    }
    /**
     * @Route("/marque/{id<[0-9]+>}", name="marque_one", methods={"GET"})
     */
    public function getone(int $id, MarqueRepository $rep){
        $data = $rep->find($id);
        return $this->json($data);
    }
    /**
     * @Route("/marque/add", name="marque_add", methods={"POST"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function add(EntityManagerInterface $emi, Request $request) : JsonResponse{
        $data = json_decode($request->getContent(), true);
        $marque = new Marque;
        $marque->setMarque($data['marque']);
        $emi->persist($marque);
        $emi->flush();
        return new JsonResponse(['status'=>'marque created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/marque/update/{id<[0-9]+>}", name="marque_update", methods={"PUT"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function update(int $id, MarqueRepository $rep, EntityManagerInterface $emi, Request $request) : JsonResponse{
        $data = json_decode($request->getContent(), true);
        $marque = $rep->find($id);
        $marque->setMarque($data['marque']);
        $emi->persist($marque);
        $emi->flush();
        return new JsonResponse(['status'=>'marque modifier'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/marque/delete/{id<[0-9]+>}", name="marque_delete", methods={"DELETE"})
     * @return JsonResponse
     */
    public function delete(int $id, MarqueRepository $rep, EntityManagerInterface $emi) : JsonResponse{
        $marque = $rep->find($id);
        $emi->remove($marque);
        $emi->flush();
        return new JsonResponse(['status'=>'marque deleted'], Response::HTTP_CREATED);
    }
}
