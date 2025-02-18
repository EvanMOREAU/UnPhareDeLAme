<?php

namespace App\Form;

use App\Entity\Consultant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null,[
                'attr'   => [
                    'class' => 'form-control',
                ],
            ])
            ->add('lastName', null,[
                'attr'   => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateNaiss', null, [
                'widget' => 'single_text',
                'attr'   => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultant::class,
        ]);
    }
}
