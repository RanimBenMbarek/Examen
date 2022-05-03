<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'app_to_do')]
    public function index(SessionInterface $session): Response
    {
        if(!$session->has('todos')){
            $todos = array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $this->addFlash('welcome',"Bienvenu");
            $session->set('todos',$todos);
        }
        return $this->render('to_do/accueil.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }
    /**
     * @Route ("/add/{cle}/{element}",name="todo.add")
     */
    public function add($cle,$element,SessionInterface $session){
        if(!$session->has('todos')){
            $this->addFlash('warning',"la liste n' est pas encore initialisee ");

        }
        else{
            $todos=$session->get('todos');
            $todos[$cle]=$element;
            $session->set('todos',$todos);
            $this->addFlash("success"," le to do a ete ajoute avec success");
        }
        return $this->redirectToRoute("app_to_do");
    }
    /**
     * @Route ("/delete/{cle}",name="todo.delete")
     */
    public function delete($cle,SessionInterface $session){
        if(!$session->has('todos')){
            $this->addFlash('warning',"la liste n' est pas encore initialisee ");

        }
        else{
            $todos=$session->get('todos');
            unset($todos[$cle]);
            $session->set('todos',$todos);
            $this->addFlash("success"," le to do a ete supprime avec success");
        }
        return $this->redirectToRoute("app_to_do");
    }
    /**
     * @Route ("/reset",name="todo.reset")
     */
    public function reset(SessionInterface $session){
        if(!$session->has('todos')){
            $this->addFlash('warning',"la liste n' est pas encore initialisee ");

        }
        else{
            $session->clear();
        }
        return $this->redirectToRoute("app_to_do");
    }

}
