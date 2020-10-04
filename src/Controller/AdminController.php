<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/all", name="admin_all", methods={"GET"})
     */
    public function getAll(AdminRepository $rep){
        return $this->json($rep->findAll());
    }
    /**
     * @Route("/admin/{id<[0-9]+>}", name="admin_one", methods={"GET"})
     */
    public function getOne(int $id, AdminRepository $rep){
        return $this->json($rep->find($id));
    }
    /**
     * @Route("/admin/add", name="admin_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $emi, Request $request):JsonResponse{

        $data = json_decode($request->getContent(), true);
        $admin = new Admin;
        $admin->setPrenom($data['prenom']);
        $admin->setNom($data['nom']);
        $admin->setCivilite($data['civilite']);
        $admin->setEmail($data['email']);
        $admin->setTel($data['tel']);
        $admin->setUserName($data['username']);
        $admin->setPassword($data['password']);
        $emi->persist($admin);
        $emi->flush();

        return new JsonResponse(['status'=>'Admin created'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/admin/update/{id<[0-9]+>}", name="admin_update", methods={"PUT"})
     */
    public function update(int $id, EntityManagerInterface $emi, Request $request, AdminRepository $rep):JsonResponse{

        $data = json_decode($request->getContent(), true);
        $admin = $rep->find($id);
        $admin->setPrenom($data['prenom']);
        $admin->setNom($data['nom']);
        $admin->setCivilite($data['civilite']);
        $admin->setEmail($data['email']);
        $admin->setTel($data['tel']);
        $admin->setUserName($data['username']);
        $admin->setPassword($data['password']);
        $emi->persist($admin);
        $emi->flush();

        return new JsonResponse(['status'=>'Admin updated'], Response::HTTP_CREATED);
    }
    /**
     * @Route("/admin/delete/{id<[0-9]+>}", name="admin_delete", methods={"DELETE"})
     */
    public function delete(int $id, EntityManagerInterface $emi, AdminRepository $rep):JsonResponse
    {

        $admin = $rep->find($id);
        $emi->remove($admin);
        $emi->flush();

        return new JsonResponse(['status'=>'Admin deleted'], Response::HTTP_CREATED);
    }
}
