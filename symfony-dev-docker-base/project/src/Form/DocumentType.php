<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\Home;
use App\Entity\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('doc')
            ->add('request', EntityType::class, [
                'class' => Request::class,
                'choice_label' => 'email',
            ])
            ->add('home', EntityType::class, [
                'class' => Home::class,
                'choice_label' => 'adress',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
