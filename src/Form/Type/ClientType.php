<?php

namespace GoDevis\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('raisonSociale', TextType::class)
                ->add('adresse1', TextType::class, array('required' => false))
                ->add('adresse2', TextType::class, array('required' => false))
                ->add('adresse3', TextType::class, array('required' => false))
                ->add('codePostal', TextType::class, array('required' => false))
                ->add('ville', TextType::class, array('required' => false))
                ->add('telephone', TextType::class, array('required' => false))
                ->add('fax', TextType::class, array('required' => false));
    }

    public function getName()
    {
        return 'client';
    }
}
