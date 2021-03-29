<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormTypeInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
                'attr' => array('class' => 'form-control', 'style' => 'line-height: 20px;'), 'label' => 'Crée le ',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'multiple' => false,
                'choice_label' => 'title',
                'label' => 'Category',
                'placeholder' => 'Choose category..',

            ])
            ->add('image', FileType::class, [
                'label' => 'image',
                'required' => false,
                // mapped false signifie qu'on ne veut pas que symfony
                // gère l'enregistrement de ce champs dans notre entité Article (donc
                // dans notre article en bdd). On va le faire ici manuellement
                'mapped' => false
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
