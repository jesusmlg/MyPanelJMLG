<?php

namespace BeerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class BeerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',
                      TextType::class,
                      array('attr' => array ('class' => 'form-control'))
                     )
                //->add('path')
                ->add('comments',TextareaType::class, array('attr' => array ('class' => 'form-control'),
                                                            'required' =>false)
                                                           )
                ->add('top',IntegerType::class, array('attr'=> array ('class' => 'form-control' )))
                ->add('price',NumberType::class, array('attr' => array ('class' => 'form-control')))
                ->add('graduation',NumberType::class, array('attr' => array ('class' => 'form-control')))
                ->add('img',FileType::class, array('attr' => array ('class' => 'form-control'), 
                                                    'required' => false)
                                                   )
                ->add('save',SubmitType::class, array('label'=> 'Guardar Cerveza', 
                                                       'attr' => array('class' => 'btn btn-primary form-control')
                                                       
                                                     )
                    )
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BeerBundle\Entity\Beer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'beerbundle_beer';
    }


}
