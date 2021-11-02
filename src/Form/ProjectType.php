<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\ProjectDocuments;
use App\Entity\TypeProject;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('createdAt',DateTimeType::class,[
                'date_widget' => 'single_text'
            ])
            ->add('ModifiedAt')
            ->add('TypeProject',EntityType::class,[
                'class'=>TypeProject::class
            ])
            ->add('client', EntityType::class,[
                'class' => Client::class
            ])
            ->add('docFiles', FileType::class, [
                'required' => false,
                'multiple' => true
            ])
            ->add('description',CKEditorType::class,[
                'enable' => true,
                'autoload' => true,
                'inline' => false,
//                'async' => true,
                'config'=> [
                    //'uiColor' => '#2832aa',

                ],
//                'config_name' => 'my_config'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
