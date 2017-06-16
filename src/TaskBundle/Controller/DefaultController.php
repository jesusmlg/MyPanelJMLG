<?php

namespace TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\TaskCategory;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use TaskBundle\Forms\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class DefaultController extends Controller
{
    /**
     * @Route("/tasks", name="all_tasks")
     * @Route("/oldtasks", name="old_tasks")
     */
    public function indexAction(Request $request)
    {                          
        //$repo = $this->getDoctrine()->getManager()->getRepository('TaskBundle:Task');
        //$tasks = $repo->findTasksIndex($request->request->get('taskCategory'),$done);

        $taskCategory = new TaskCategory();
        $formCat = $this->createFormBuilder($taskCategory)
            ->add('name',EntityType::class,array(
                'class' => 'TaskBundle:TaskCategory',
                'expanded' => false,
                'choice_label' => 'name',
                'placeholder' => 'Todas',
                'attr' => array ('class' => 'select_category'),
                'label' => 'Categoría:'
                ))
            ->getForm();
        //$repo = $this->getDoctrine()->getManager()->getRepository('TaskBundle:Task');
        //$tasks = $repo->findTasksIndex($request->request->get('taskCategory'),$done);
        $jsonValues = json_encode('');

        if($request->isXMLHttpRequest())
        {
            //return new JsonResponse(array('data' => 'this is a json response', 'url' => $this->generateUrl('new_task')));
            return new JsonResponse();
        }

        return $this->render('TaskBundle:Default:index.html.twig',  array('formCat' => $formCat->createView()));
    }

    /**
     * @Route("/taskslist", name="all_tasks_list")
     * @Method({"POST","GET"})
     */
    public function taskListAction(Request $request, $url="")
    {
        if($url == "")
            $url = $request->request->get("url");

        if( $url == $this->generateUrl('all_tasks') )
            $done = 0;
        else
            $done = 1;

        $repo = $this->getDoctrine()->getManager()->getRepository('TaskBundle:Task');

        /*$tasks = $repo->findBy(
            array('done' => $done, 'taskCategory' =>''),
            array('duedate' => 'DESC', 'important'=>'DESC')
            );*/
        $tasks = $repo->findTasksIndex($request->request->get('taskCategory'),$done);

        //$respond['html'] = $this->render('TaskBundle:Default:tasklist.html.twig',  array('tasks' => $tasks, 'url' => $url));
        //$respond['hola'] = "hola";

        //return  new JsonResponse(($respond));

        return $this->render('TaskBundle:Default:tasklist.html.twig',  array('tasks' => $tasks, 'url' => $url));
    }
	
	/**
	 * @Route("/task/new", name="new_task")
	 */
    public function newAction(Request $request)
    {
    	$task = new Task();

    	$form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid())
        {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            return $this->redirectToRoute('new_task');

        }

    		return $this->render('TaskBundle:Default:new.html.twig', array('form'=>$form->createView()));

    }

    /**
      *@Route("/task/{id}/edit", name="edit_task")
     */
    public function editAction(Request $request, $id)
    {
        $task = new Task();

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TaskBundle:Task');

        $task = $repo->find($id);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted()  && $form->isValid())
        {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            return $this->redirectToRoute('all_tasks');

        }

            return $this->render('TaskBundle:Default:new.html.twig', array('form'=>$form->createView(),'edit' => true));

    }

    /**
      * @Route("/checkdone", name="checkdone")
      * @Method({"POST","GET"})
      */
    public function CheckDoneAction(Request $request)
    {
        //$request->get()
        $values = $request->request->get('checkedValues');
        $arrayvalues = explode(",",$values);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TaskBundle:Task');


        foreach ($arrayvalues as $key => $value) 
        {
            $task = $repo->find($value);
            $task->setDone(true);

            $em->persist($task);
            $em->flush();
        }

        $jsonValues = json_encode($values);
        //echo var_dump($values);

        //return $this->render('TaskBundle:Default:checkdone.html.twig');
        //return new Response('<html><body>Lucky number: 1</body></html>');

        if($request->isXMLHttpRequest())
        {
            //return new JsonResponse(array('data' => 'this is a json response', 'url' => $this->generateUrl('new_task')));
            return new JsonResponse($jsonValues);
        }
        else
        {
            return new Response('This is not ajax!', 404);
        }
        //return $this->redirectToRoute('new_task');
    }
}
