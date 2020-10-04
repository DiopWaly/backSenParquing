<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index()
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    /**
     * @Route("/categorie/all", name="categorie_all", methods={"GET"})
     */
    public function getall(CategorieRepository $rep){
        $data = $rep->findAll();
        return $this->json($data);
    }
    /**
     * @Route("/categorie/{id<[0-9]+>}", name="categorie_one", methods={"GET"})
     */
    public function getone(int $id, CategorieRepository $rep){
        $data = $rep->find($id);
        return $this->json($data);
    }
    /**
     * @Route("/categorie/add", name="categorie_add", methods={"POST"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function add(EntityManagerInterface $emi, Request $request) : JsonResponse{
        $data = json_decode($request->getContent(), true);
        $categorie = new Categorie;
        $categorie->setCategorie($data['categorie']);
        $emi->persist($categorie);
        $emi->flush();
        return new JsonResponse(['status'=>'categorie created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/categorie/update/{id<[0-9]+>}", name="categorie_update", methods={"PUT"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function update(int $id, CategorieRepository $rep, EntityManagerInterface $emi, Request $request) : JsonResponse{
        $data = json_decode($request->getContent(), true);
        $categorie = $rep->find($id);
        $categorie->setCategorie($data['categorie']);
        $emi->persist($categorie);
        $emi->flush();
        return new JsonResponse(['status'=>'categorie modifier'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/categorie/delete/{id<[0-9]+>}", name="categorie_delete", methods={"DELETE"})
     * @return JsonResponse
     */
    public function delete(int $id, CategorieRepository $rep, EntityManagerInterface $emi) : JsonResponse{
        // $data = json_decode($request->getContent(), true);
        $categorie = $rep->find($id);
        $emi->remove($categorie);
        $emi->flush();
        return new JsonResponse(['status'=>'categorie deleted'], Response::HTTP_CREATED);
    }
}
