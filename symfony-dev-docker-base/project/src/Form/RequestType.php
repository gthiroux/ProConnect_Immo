<?php

namespace App\Form;

use App\Entity\Home;
use App\Entity\Request;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('tel')
            ->add('date')
            ->add('status')
            ->add('code_mail')
            ->add('UUID')
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'id',
            ])
            ->add('house', EntityType::class, [
                'class' => Home::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
