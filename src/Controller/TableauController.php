<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableauController extends AbstractController
{
    #[Route('/tableau/{nbre?5}', name: 'app_tableau')]
    public function index($nbre): Response
    {
        for ($i=0;$i<$nbre;$i++){
            $tab[$i]=rand(0,20);
        }
        return $this->render('tableau/accueil.html.twig', [
            'controller_name' => 'TableauController',
            'tab'=>$tab,
            'path'=>''
        ]);
    }
    /**
     * @Route ("/tab/users",name="tab.users")
     */
    public function users():Response{
        $tab=[
            ['name'=>'ranim','Firstname'=>'mbarek','age'=>'20'],
            ['name'=>'rawen','Firstname'=>'mbarek','age'=>'16'],
            ['name'=>'emna','Firstname'=>'mbarek','age'=>'14'],
            ['name'=>'amal','Firstname'=>'hechi','age'=>'22'],
            ['name'=>'zeineb','Firstname'=>'abdallah','age'=>'16'],
        ];
        return $this->render('tableau/users.html.twig',[
            'tab'=>$tab
        ]);
    }
}
