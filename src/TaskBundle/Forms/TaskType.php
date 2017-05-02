<?php

namespace TaskBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


/**
* 
*/
class TaskType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name',TextType::class)
    		->add('duedate',DateType::class, array(
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'data' =>  date_add(new \DateTime("now"), date_interval_create_from_date_string('1 day'))
                ))
    		->add('important',CheckboxType::class,array('required' => false))
    		->add('taskcategory',EntityType::class,array(
                'class' => 'TaskBundle:TaskCategory',
                'expanded' => false,
                'choice_label' => 'name',
                'placeholder' => 'All',             
                ))
            ->add('save',SubmitType::class, array('label'=> 'Guardar Tarea'))
    		
    		;
	}
}

?>