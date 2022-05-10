<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Marque;

class MarqueController extends AbstractController
{
    /**
     * @Route("/marque", name="marque")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MarqueController.php',
        ]);
    }
    /**
     * @Route("/insertMarque/{nom}",name="insertMarque",requirements={"nom"="[a-z]{4,30}"})
     */
    public function insert(Request $request, $nom)
    {
        $marq = new Marque();
        $marq->setNom($nom);

        if ($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($marq);
            //insertion en bdd
            $em->flush();
            $resultat = ["ok"];
        } else {
            $resultat = ["nok"];
        }

        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
    /**
     * @Route("/deleteMarque/{id}", name="deleteMarque",requirements={"id"="[0-9]{1,5}"})
     */
    public function delete(Request $request, $id)
    {
        //récupération du Manager et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $marqueRepository = $em->getRepository(Marque::class);
        //requete de selection
        $marq = $marqueRepository->find($id);
        //suppression de l'entity
        $em->remove($marq);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
