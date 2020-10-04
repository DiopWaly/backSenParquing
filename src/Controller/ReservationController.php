<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\AnneeRepository;
use App\Repository\CategorieRepository;
use App\Repository\ChauffeurRepository;
use App\Repository\ClientRepository;
use App\Repository\MarqueRepository;
use App\Repository\ModeleRepository;
use App\Repository\ReservationRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index()
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    /**
     * @Route("/reservation/all", name="reservation_all", methods={"GET"})
     */
    public function getAll(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn,
                            ModeleRepository $repMod, VoitureRepository $repvoi, ClientRepository $repcli,
                              ChauffeurRepository $repcha, EntityManagerInterface $emi, Request $request, 
                                ReservationRepository $rep)
    {
         return $this->json($rep->findAll());
    }
    /**
     * @Route("/reservation/{id<[0-9]+>}", name="reservation_one", methods={"GET"})
     */
    public function getOne(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn,
                            ModeleRepository $repMod, VoitureRepository $repvoi, ClientRepository $repcli,
                              ChauffeurRepository $repcha, EntityManagerInterface $emi, Request $request, 
                                ReservationRepository $rep, int $id)
    {
        return $this->json($rep->find($id));
    }
    /**
     * @Route("/reservation/add", name="reservation_add", methods={"POST"})
     */
    public function add(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn,
                            ModeleRepository $repMod, VoitureRepository $repvoi, ClientRepository $repcli,
                                ChauffeurRepository $repcha, EntityManagerInterface $emi, Request $request):JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $reservation = new Reservation;
        $client = $repcli->find($data['client']);
        $chauffeur = $repcha->find($data['chauffeur']);
        $voiture = $repvoi->find($data['voiture']);
        $reservation->setWithdriver($data['withdriver']);
        $reservation->setDateReservation($data['datereservation']);
        $reservation->setDateRetour($data['dateretour']);
        $reservation->setTarif($data['tarif']);
        $reservation->setClient($data['client']);
        $reservation->setChauffeur($data['chauffeur']);
        $reservation->setVoiture($data['voiture']);
        
        $emi->persist($reservation);
        $emi->flush();

        return new JsonResponse(['status'=>'Reservation create'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/reservation/update/{id<[0-9]+>}", name="reservation_update", methods={"PUT"})
     */
    public function update(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn,
                                ModeleRepository $repMod, VoitureRepository $repvoi, ClientRepository $repcli,
                                    ChauffeurRepository $repcha, EntityManagerInterface $emi, Request $request, 
                                        ReservationRepository $rep, int $id):JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $reservation = $rep->find($id);
        $client = $repcli->find($data['client']);
        $chauffeur = $repcha->find($data['chauffeur']);
        $voiture = $repvoi->find($data['voiture']);
        $reservation->setWithdriver($data['withdriver']);
        $reservation->setDateReservation($data['datereservation']);
        $reservation->setDateRetour($data['dateretour']);
        $reservation->setTarif($data['tarif']);
        $reservation->setClient($data['client']);
        $reservation->setChauffeur($data['chauffeur']);
        $reservation->setVoiture($data['voiture']);
        
        $emi->persist($reservation);
        $emi->flush();

        return new JsonResponse(['status'=>'Reservation updated'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/reservation/delete/{id<[0-9]+>}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(MarqueRepository $repMar, CategorieRepository $repCat, AnneeRepository $repAn,
                             ModeleRepository $repMod, VoitureRepository $repvoi, ClientRepository $repcli,
                                ChauffeurRepository $repcha, EntityManagerInterface $emi, 
                                   ReservationRepository $rep, int $id):JsonResponse
    {
        $reservation = $rep->find($id);
        $emi->remove($reservation);
        $emi->flush();

        return new JsonResponse(['status'=>'Reservation deleted'], Response::HTTP_CREATED);
    }
}
