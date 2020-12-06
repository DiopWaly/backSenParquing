<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index()
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    /**
     * @Route("/client/all", name="client_all", methods={"GET"})
     */
    public function getAll(ClientRepository $rep){
        return $this->json($rep->findAll());
    //    dd($rep->findclient('774420687', 'degga'));
    }
    /**
     * @Route("/client/{id<[0-9]+>}", name="client_one", methods={"GET"})
     */
    public function getOne(int $id, ClientRepository $rep){
        // dd(sha1('degga'));
        return $this->json($rep->find($id));
    }
    /**
     * @Route("/client/login", name="client_login", methods={"PATCH"})
     */
    public function login(Request $request, ClientRepository $rep){
        $data = json_decode($request->getContent(), true);
        return $this->json($rep->findclient($data['email'], sha1($data['password'])));
    }
    /**
     * @Route("/client/add", name="client_add", methods={"POST","GET"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function add(EntityManagerInterface $emi,Request $request) : JsonResponse{

        $data = json_decode($request->getContent(), true);
        $client = new Client;
        $client->setPrenom($data['prenom']);
        $client->setNom($data['nom']);
        $client->setCivilite($data['civilite']);
        $client->setDateNaissance(new DateTime($data['datenaissance']));
        $client->setLieuNaissance($data['lieunaissance']);
        $client->setAdresse($data['adresse']);
        $client->setEmail($data['email']);
        $client->setTel($data['tel']);
        $client->setNumPermis($data['numpermis']);
        $client->setPassword(sha1($data['password']));
        $client->setUserName($data['username']);
        $emi->persist($client);
        $emi->flush();

        return new JsonResponse(['status'=>'Client created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/client/update/{id<[0-9]+>}", name="client_update", methods={"PUT","GET"})
     * @param Requeste $requeste
     * @return JsonResponse
     */
    public function update(int $id,ClientRepository $rep, EntityManagerInterface $emi,Request $request):JsonResponse{

        $data = json_decode($request->getContent(), true);
        $client = $rep->find($id);
        $client->setPrenom($data['prenom']);
        $client->setPrenom($data['nom']);
        $client->setCivilite($data['civilite']);
        $client->setDateNaissance($data['datenaissance']);
        $client->setLieuNaissance($data['lieunaissance']);
        $client->setAdresse($data['adresse']);      
        $client->setEmail($data['email']);
        $client->setTel($data['tel']);
        $client->setNumPermis($data['numpermis']);
        $client->setPassword($data['password']);
        $client->setUserName($data['username']);
        $emi->persist($client);
        $emi->flush();

        return new JsonResponse(['status'=>'Client updated'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/client/delete/{id<[0-9]+>}", name="client_delete", methods={"DELETE","GET"})
     * @return JsonResponse
     */
    public function delete(int $id,ClientRepository $rep, EntityManagerInterface $emi):JsonResponse{

        $client = $rep->find($id);
        $emi->remove($client);
        $emi->flush();
        return new JsonResponse(['status'=>'Client deleted'], Response::HTTP_CREATED);
    }
}
