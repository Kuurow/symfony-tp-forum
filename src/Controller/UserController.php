<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/add", name="userAdd")
     */
    public function index()
    {
        # code...
    }
    /**
     * @Route("/add", name="userAdd")
     */
    public function add(Request $request)
    {
        $userForm = new User();
        $form = $this->createForm(UserType::class, $userForm);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $doctrine = $this->getDoctrine();
            $manager = $doctrine->getManager();
            $manager->persist($person);
            $manager->flush();
        }


        return $this->render('user/add.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }


    /**
     * @Route("/list", name="userList")
     */
    public function list(): Response
    {
        $doctrine = $this->getDoctrine(); // On récupère l'ORM
        $manager = $doctrine->getManager(); // On récupère le Manager
        $repositoryPerson = $manager->getRepository(User::class); // On récupère la table Person

        return $this->render('user/list.html.twig', [
            'users' => $repositoryPerson->findAll(),
        ]);
    }
}
