<?php

namespace EvenementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('description')->add('prix')->add('lieux')->add('dateDeb',DateTimeType::class, array(
            'widget' => 'choice', 'years' => range(date('Y'),date('Y')+50),
            'label' => 'Date de Debut', 'required' => true))

            ->add('dateFin',DateTimeType::class, array(
            'widget' => 'choice', 'years' => range(date('Y'),date('Y')+100),
            'label' => 'Date de Fin', 'required' => true
        ))->add('file');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenement';
    }


}
