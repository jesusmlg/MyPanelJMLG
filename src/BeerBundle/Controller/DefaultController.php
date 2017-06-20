<?php

namespace BeerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\File\File;
use BeerBundle\Entity\Beer;
use BeerBundle\Form\BeerType;


class DefaultController extends Controller
{
    /**
     * @Route("/beers", name="all_beers")
     */
    public function indexAction()
    {
        $beers = new Beer();

        $beers = $this->getDoctrine()->getManager()->getRepository('BeerBundle:Beer')->findAll();

        return $this->render('BeerBundle::index.html.twig', array('beers' => $beers));
    }

    /**
	 * @Route("/beer/new", name="new_beer")	
     */
    public function newAction(Request $request)
    {
    	$beer = new Beer();

    	$form = $this->createForm(BeerType::class, $beer);

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid())
        {
            $beer = $form->getData();
            $img = $beer->getImg();
            $filename = md5(uniqid()).'.'.$img->guessExtension();

            $img->move(
            	$this->getParameter('beer_img_directory'),
            	$filename
            	);
            
            	$beer = $form->getData();
            	
            	$beer->setImg($filename);
            	//$beer->setImg(new File($this->getParameter('beer_img_directory').'/'.$beer->getImg()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();
            
            return $this->redirectToRoute('all_beers');

        }

    	return $this->render('BeerBundle::new.html.twig',array('form' => $form->createView()));
    }

    /**
	 * @Route("/beer/{id}", name="beer")	
    */

    public function beerAction(Request $request, $id)
    {
    	$beer = new Beer();

    	$beer = $this->getDoctrine()->getManager()->getRepository('BeerBundle:Beer')->find($id);

    	return $this->render('BeerBundle::beer.html.twig', array('beer' => $beer));
    }

    /**
     * @Route ("/beer/{id}/delete",name = "delete_beer")
     * @Method({"DELETE","GET"})
     */

    public function deleteAction(Request $request, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	//$id = $request->request()->get('id');
    	//$id = $request->query->get('id');

    	$beer = new Beer();
    	$beer = $em->getRepository('BeerBundle:Beer')->find($id);

    	if($beer)
    	{
    		$em->remove($beer);
    		$em->flush();
    		return $this->redirectToRoute('all_beers'); 
    	}

    }
}
