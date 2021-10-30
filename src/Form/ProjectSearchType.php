<?php

namespace App\Form;


use App\Entity\Project;
use App\Entity\TypeProject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProjectSearchType extends AbstractType
{

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('projects', SearchableEntityType::class,[
                'class' => Project::class,
                'required' => false,
                'multiple' => true,
                'search' => $this->urlGenerator->generate('api_projects'),
                'label_property' => 'code'

            ])
            ->add('typeProject', EntityType::class,[
                'class' => TypeProject::class,
                'required' => false,
                'multiple' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
