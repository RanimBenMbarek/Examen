<?php

namespace App\Controller;

use App\Entity\Restau;
use App\Entity\Users;
use App\Form\RestauType;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request,ManagerRegistry $doctrine,SessionInterface $session): Response
    {
        $user=new Users();
        if(!$session->has('user')){
            $form=$this->createForm(UserType::class,$user);
            $form->handleRequest($request);
            //tverifi les données
            if($form->isSubmitted()) {
                $data = $form->getData();
                $repository = $doctrine->getRepository(Users::class);
                $personne = $repository->findOneBy(['email' => $data->getEmail(),'password' => $data->getPassword()]);
                //tkharej error wtraj3a lil form
                if ($personne == null) {
                    $this->addFlash('warning', 'incorrect');
                    return $this->redirectToRoute("app_login");
                } //tkharej success wt3adih lil acceuil
                else {
                    $user->setEmail($data->getEmail());
                    $user->setPassword($data->getPassword());
                    $session->set("user",$user);
                    $this->addFlash("success", "Bienvenu");
                    return $this->render('login/accueil.html.twig');
                }
            }
            //t3awed traj3a lil form in case ma submitta chay
            else{

                return  $this->render("login/page.html.twig",[
                    'form'=>$form->createView()
                ]);
            }
        }else{
            return $this->redirectToRoute("app_accueil");
        }
    }
    /**
     * @Route("/accueil",name="app_accueil")
     */
    public function accueil(ManagerRegistry $doctrine){
        $repository=$doctrine->getRepository(Restau::class);
        $restaus=$repository->findAll();
        return $this->render('login/accueil.html.twig',[
           'restaus'=>$restaus
        ]);
    }
    /**
     * @Route("/update/{id?0}",name="app_update")
     */
    public function update(ManagerRegistry $doctrine,Request $request,Restau $restau=null){
        // bch nasna3 form wnediti fih
    if($restau){
        $entitymanager=$doctrine->getManager();
        $form=$this->createForm(RestauType::class,$restau);
        $form->handleRequest($request);
//        badel ldata wpersisti wraj3a msg success w3awd raj3a lil acceuil
        if($form->isSubmitted()){
            $entitymanager->persist($restau);
            $entitymanager->flush();
            $this->addFlash('success',"le restau est mis à jour");
           return $this->redirectToRoute('app_accueil');
        }
//  raj3a lil formulaire

        else{
           return $this->render('login/add.html.twig' , ['form'=>$form->createView()]);
        }
    }
//    nraja3 error restau not found wnraj3a lil acceuilreturn
    else{
        $this->addFlash('error',"le restau n'existe pas");
        return $this->redirectToRoute('app_accueil');
    }
    }
    /**
     * @Route("/delete/{id}",name="app_delete")
     */
    public function delete(Restau $restau=null,EntityManagerInterface $manager){
        $RestauName=$restau->getName();
        $manager->remove($restau);
        $this->addFlash("success","le restau $RestauName a ete supprime avec succes");
        return $this->redirectToRoute('app_accueil');
    }
    /**
     * @Route ("/add",name="app_add")
     */
    public function add(Request $request,EntityManagerInterface $manager){
        $restau=new Restau();
        $form=$this->createForm(RestauType::class,$restau);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data=$form->getData();
            $manager->persist($data);
            $manager->flush();
            $this->addFlash("success","un nouveau restau a ete ajoute avec success");
            return $this->redirectToRoute('app_login');
        }else{
            return $this->render('login/add.html.twig',[
                'form'=>$form->createView()
            ]);
        }
    }
}
