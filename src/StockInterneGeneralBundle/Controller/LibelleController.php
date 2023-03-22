<?php

namespace StockInterneGeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\LibelleGeneral;

class LibelleController extends Controller
{


	public function indexAction()
    {

    	$user = $this->getUser();
        $userAgence = $this->getDoctrine()
                    ->getRepository('AppBundle:UserAgence')
                    ->findOneBy(array(
                        'user' => $user
                    ));
                    
        $agence = $userAgence->getAgence();

        return $this->render('StockInterneGeneralBundle:Libelle:index.html.twig',array(
        ));
    }

    public function listAction(Request $request)
    {
        $user = $this->getUser();
        $userAgence = $this->getDoctrine()
                    ->getRepository('AppBundle:UserAgence')
                    ->findOneBy(array(
                        'user' => $user
                    ));
                    
        $agence_id = $userAgence->getAgence()->getId();

        $libelles = $this->getDoctrine()
                ->getRepository('AppBundle:LibelleGeneral')
                ->list($agence_id);

        return new JsonResponse($libelles);
    }

    public function saveAction(Request $request)
    {
        $nom = $request->request->get('nom');
        $description = $request->request->get('description');
        $id = $request->request->get('id');

        $user = $this->getUser();
        $userAgence = $this->getDoctrine()
                    ->getRepository('AppBundle:UserAgence')
                    ->findOneBy(array(
                        'user' => $user
                    ));
                    
        $agence = $userAgence->getAgence();

        if ($id) {
            $libelle = $this->getDoctrine()
                    ->getRepository('AppBundle:LibelleGeneral')
                    ->find($id);
        } else {
            $libelle = new LibelleGeneral();
        }

        $libelle->setNom($nom);
        $libelle->setAgence($agence);

        $em = $this->getDoctrine()->getManager();
        $em->persist($libelle);
        $em->flush();

        if ($libelle->getId()) {
            return new Response(200);
        }
        
    }

    public function deleteAction($id)
    {
        $libelle  = $this->getDoctrine()
                        ->getRepository('AppBundle:LibelleGeneral')
                        ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($libelle);
        $em->flush();

        return new JsonResponse(200);
        
    }

    public function editorAction(Request $request)
    {
        $id = $request->request->get('id');
        $libelle = $this->getDoctrine()
        	->getRepository('AppBundle:LibelleGeneral')
            ->find($id);

        $user = $this->getUser();
        $userAgence = $this->getDoctrine()
                    ->getRepository('AppBundle:UserAgence')
                    ->findOneBy(array(
                        'user' => $user
                    ));
                    
        $agence = $userAgence->getAgence();

        return $this->render('@StockInterneGeneral/Libelle/editor.html.twig',[
            'libelle' => $libelle,
        ]);
    }


}
