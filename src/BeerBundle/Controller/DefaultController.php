<?php

namespace BeerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BeerBundle\Entity\Beer;
use BeerBundle\Form\BeerType;


class DefaultController extends Controller
{
    /**
     * @Route("/beers")
     */
    public function indexAction()
    {
        return $this->render('BeerBundle:Default:index.html.twig');
    }

    /**
	 * @Route("/beer/new", name="new_beer")	
     */
    public function newAction(Request $request)
    {
    	$beer = new Beer();

    	$form = $this->createForm(BeerType::class, $beer);

    	$form->handleRequest($request);

    	if($form->isSubmitted()  && $form->isValid())
        {
            $beer = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();
            
            return $this->redirectToRoute('new_beer');

        }

    	return $this->render('BeerBundle::new.html.twig',array('form' => $form->createView()));
    }
}
