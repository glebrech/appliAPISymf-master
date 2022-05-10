<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    /**
 * @Route("/insertUser/{nom}",name="insertUser",requirements={"nom"="[a-z]{4,30}"})
 */
 public function insert(Request $request,$nom)
 {
 $use=new User();
 $use->setNom($nom);

 if($request->isMethod('get')){
 //récupération de l'entityManager pour insérer les données en bdd
 $em=$this->getDoctrine()->getManager();

 $em->persist($use);
 //insertion en bdd
 $em->flush();
 $resultat=["ok"];
 }
 else {
 $resultat=["nok"];
 }

 $reponse=new JsonResponse($resultat);
 return $reponse;

 } 
 /**
 * @Route("/deleteUser/{id}", name="deleteUser",requirements={"id"="[0-9]{1,5}"})
 */
public function delete(Request $request,$id)
{
//récupération du Manager et du repository pour accéder à la bdd
$em=$this->getDoctrine()->getManager();
$userRepository=$em->getRepository(User::class);
//requete de selection
$use=$userRepository->find($id);
//suppression de l'entity
$em->remove($use);
$em->flush();
$resultat=["ok"];
$reponse=new JsonResponse($resultat);
return $reponse;
}

}
