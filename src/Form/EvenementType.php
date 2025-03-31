<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ->add('pictures',EntityType::class, [
                'class' => Picture::class,
                'label' =>'Photo associé (facultatif)',

                'choice_label' =>function(Picture $picture): string{
                    return $picture->getDescription();
                },
                'multiple' => true         
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
