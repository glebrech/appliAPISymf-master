<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Personne;


class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PersonneController.php',
        ]);
    }

    /**
     * @Route("/insertPersonne/{nom}",name="insertPersonne",requirements={"nom"="[a-z]{4,30}"})
     */
    public function insert(Request $request, $nom)
    {
        $pers = new Personne();
        $pers->setNom($nom);
        if ($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($pers);
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
     * @Route("/deletePersonne/{id}", name="deletePersonne",requirements={"id"="[0-9]{1,5}"})
     */
    public function delete(Request $request, $id)
    {
        //récupération du Manager et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $personneRepository = $em->getRepository(Personne::class);
        //requete de selection
        $pers = $personneRepository->find($id);
        //suppression de l'entity
        $em->remove($pers);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
