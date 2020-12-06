<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\AnneeRepository;
use App\Repository\CategorieRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index()
    {
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
        ]);
    }
    /**
     * @Route("/voiture/all", name="voiture_all", methods={"GET"})
     */
    public function getAll(MarqueRepository $repMar, CategorieRepository $repCat,AnneeRepository $repAn,
                            ModeleRepository $repMod, VoitureRepository $rep)
    {
        return $this->json($rep->findAll());
    }
    /**
     * @Route("/voiture/trie/{id<[0-9]+>}", name="voiture_trie", methods={"GET"})
     */
    public function trieParCategorie(MarqueRepository $repMar, CategorieRepository $repCat,AnneeRepository $repAn,
                            ModeleRepository $repMod, VoitureRepository $rep,int $id)
    {
        return $this->json($rep->trieVoitures($repMod->findByCategorie($id)));
    }
    /**
     * @Route("/voiture/{id<[0-9]+>}", name="voiture_one", methods={"GET"})
     */
    public function getOne(MarqueRepository $repMar, CategorieRepository $repCat,AnneeRepository $repAn,
                             ModeleRepository $repMod, VoitureRepository $rep,int $id)
    {
        return $this->json($rep->find($id));
    }
    /**
     * @Route("/voiture/add", name="voiture_add", methods={"POST","GET"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function add(MarqueRepository $repMar, AnneeRepository $repAn,CategorieRepository $repCat,
                            EntityManagerInterface $emi, ModeleRepository $repMod, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $voiture = new Voiture;
        // dd($data);
        $voiture->setMatricule($data['matricule']);
        $voiture->setDescription($data['libelle']);
        $voiture->setTarifjrne($data['price']);
        $voiture->setCapacite($data['capacite']);
        $voiture->setAir($data['air']);
        $voiture->setOptions($data['option']);
        $voiture->setConditions($data['condition']);
        $voiture->setImage($data['image']);
        $modele = $repMod->find($data['modele']);
        $voiture->setModele($modele);
        $emi->persist($voiture);
        $emi->flush();
        return new JsonResponse(['status'=>'Voiture created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/voiture/update/{id<[0-9]+>}", name="voiture_update", methods={"PUT"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function update(int $id,MarqueRepository $repMar, AnneeRepository $repAn, 
                            CategorieRepository $repCat, EntityManagerInterface $emi, ModeleRepository $repMod, 
                                VoitureRepository $rep, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $voiture = $rep->find($id);
        $voiture->setMatricule($data['matricule']);
        $voiture->setDescription($data['description']);
        $voiture->setTarifjrne($data['tarifjrne']);
        $modele = $repMod->find($data['modele']);
        $voiture->setModele($modele);
        $emi->persist($voiture);
        $emi->flush();
        return new JsonResponse(['status'=>'Voiture updated'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/voiture/delete/{id<[0-9]+>}", name="voiture_delete", methods={"DELETE"})
     * @return JsonResponse
     */
    public function delete(int $id, EntityManagerInterface $emi, ModeleRepository $repMod, 
                            VoitureRepository $rep):JsonResponse
    {
        $voiture = $rep->find($id);
        $emi->remove($voiture);
        $emi->flush();
        return new JsonResponse(['status'=>'Voiture deleted'], Response::HTTP_CREATED);
    }
}
