<?php

// src/Form/ArticleType.php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('content');

        // Si on veut créer un article, pas de champ createAt
        // Sinon on affiche le champ createAt
        if (empty($options['is_create']) && false === $options['is_create']) {
            $builder->add('createAt', null, [
                'widget' => 'single_text',
            ]);
        }

        $builder
            ->add('publishedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('isPublished')
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => true,
                // pour avoir des checkbox
                'expanded' => true,
                // pour rendre le champ optionnel
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            // déclarer l'option ici, par défaut non
            'is_create' => false,
        ]);
    }
}
