<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trajet;


class TrajetController extends AbstractController
{
    /**
     * @Route("/trajet", name="trajet")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TrajetController.php',
        ]);
    }


    /**
     * @Route("/insertTrajet/{setNbKms}",name="insertTrajet",requirements={"setNbKms"="[a-z]{4,30}"})
     */
    public function insert(Request $request, $setNbKms)
    {
        $traj = new Trajet();
        $traj->setNbKms($setNbKms);
        if ($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($traj);
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
     * @Route("/insertTrajet/{setDatetrajet}",name="insertTrajet",requirements={"setDatetrajet"="[a-z]{4,30}"})
     */
    public function insert(Request $request, $setDatetrajet)
    {
        $traj = new Trajet();
        $traj->setDatetrajet($setDatetrajet);
        if ($request->isMethod('get')) {
            //récupération de l'entityManager pour insérer les données en bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($traj);
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
     * @Route("/deleteTrajet/{id}", name="deleteTrajet",requirements={"id"="[0-9]{1,5}"})
     */
    public function delete(Request $request, $id)
    {
        //récupération du Manager et du repository pour accéder à la bdd
        $em = $this->getDoctrine()->getManager();
        $trajetRepository = $em->getRepository(Trajet::class);
        //requete de selection
        $traj = $trajetRepository->find($id);
        //suppression de l'entity
        $em->remove($traj);
        $em->flush();
        $resultat = ["ok"];
        $reponse = new JsonResponse($resultat);
        return $reponse;
    }
}
