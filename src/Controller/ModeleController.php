<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Repository\AnneeRepository;
use App\Repository\CategorieRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModeleController extends AbstractController
{
    /**
     * @Route("/modele", name="modele")
     */
    public function index()
    {
        return $this->render('modele/index.html.twig', [
            'controller_name' => 'ModeleController',
        ]);
    }
    /**
     * @Route("/modele/all", name="modele_all", methods={"GET"})
     */
    public function getAll(MarqueRepository $repMar, CategorieRepository $repCat, 
                            AnneeRepository $repAn, ModeleRepository $rep)
    {
        return $this->json($rep->findAll());
    }
    /**
     * @Route("/modele/{id<[0-9]+>}", name="modele_one", methods={"GET"})
     */
    public function getOne(MarqueRepository $repMar, CategorieRepository $repCat, 
                            AnneeRepository $repAn, ModeleRepository $rep, int $id)
    {
        return $this->json($rep->find($id));
    }
    /**
     * @Route("/modele/add", name="modele_add", methods={"POST","GET"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function add(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn, 
                            ModeleRepository $rep,EntityManagerInterface $emi, Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $modele = new Modele;
        $marque = $repMar->find($data['marque']);
        $categorie = $repCat->find($data['categoire']);
        $annee = $repAn->find($data['annee']);
        $modele->setLibelle($data['libelle']);
        $modele->setMarque($data['marque']);
        $modele->setCategorie($data['categorie']);
        $modele->setAnnee($data['annee']);
        $emi->persist($modele);
        $emi->flush();

        return new JsonResponse(['status'=>'Modele created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/modele/update/{id<[0-9]+>}", name="modele_update", methods={"PUT","GET"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function update(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn, 
                            ModeleRepository $rep,EntityManagerInterface $emi, Request $request,int $id) : JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $modele = $rep->find($id);
        $marque = $repMar->find($data['marque']);
        $categorie = $repCat->find($data['categoire']);
        $annee = $repAn->find($data['annee']);
        $modele->setLibelle($data['libelle']);
        $modele->setMarque($data['marque']);
        $modele->setCategorie($data['categorie']);
        $modele->setAnnee($data['annee']);
        $emi->persist($modele);
        $emi->flush();

        return new JsonResponse(['status'=>'Modele updateted'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/modele/delete/{id<[0-9]+>}", name="modele_delete", methods={"DELETE","GET"})
     * @return JsonResponse
     */
    public function delete(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn, 
                            ModeleRepository $rep,EntityManagerInterface $emi, int $id) : JsonResponse
    {
        $modele = $rep->find($id);
        $emi->remove($modele);
        $emi->flush();
        return new JsonResponse(['status'=>'Modele deleted'], Response::HTTP_CREATED);
    }
}
