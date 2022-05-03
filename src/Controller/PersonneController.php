<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'app_personne')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Personne::class);
        $personnes=$repository->findByAge(12);
        return $this->render('personne/personne.html.twig', [
            'personnes'=>$personnes,
        ]);
    }
    /**
     * @Route("/add/{name}/{firstname}/{age}",name="personne.add")
     */
    public function add($name,$firstname,$age,EntityManagerInterface $manager){
        $personne=new Personne();
        $personne->setAge($age);
        $personne->setName($name);
        $personne->setFirstname($firstname);
        $manager->persist($personne);
        $manager->flush();
        $this->addFlash("success","le personne $name $firstname a ete ajoute avec succes");
        return $this->redirectToRoute("app_personne");
    }
    /**
     * @Route("/delete/{id}",name="personne.delete")
     */
    public function delete(Personne $personne,EntityManagerInterface $manager){
        $manager->remove($personne);
        $manager->flush();
        $this->addFlash("success","le personne a ete supprime avec succes");
        return $this->redirectToRoute("app_personne");
    }
}
