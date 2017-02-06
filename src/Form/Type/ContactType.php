<?php

namespace GoDevis\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, array('required' => false))
                ->add('prenom', TextType::class, array('required' => false));
    }

    public function getName()
    {
        return 'contact';
    }
}
