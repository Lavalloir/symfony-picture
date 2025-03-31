<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filename', TextType::class, [
                'label' => "Nom du fichier"
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date de prise'
            ])
            ->add('description', null, [
                'label' => 'Description de la photo'
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
            ->add('evenement',EntityType::class, [
                'class' => Evenement::class,
                'label' =>'Evenement associé (facultatif)',

                'choice_label' =>function(Evenement $event): string{
                    return $event->getTitle();
                },
                'required' => false          
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
