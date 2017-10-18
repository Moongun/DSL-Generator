<?php

namespace DSL\DSLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class IngredientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // TODO dorobić walidacje - sprawdzić czy jest w entity
        //dokończyć
        $builder
                ->add('mealId', HiddenType::class, array(
                    'data' => $options['mealId'],
                    'required' => true
                    )
                )
                ->add('productId')
                ->add('quantity', NumberType::class, array(
                    'required' => true
                    )
                )
                ->add('meal')
                ->add('product');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSL\DSLBundle\Entity\Ingredient',
            'mealId' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dsl_dslbundle_ingredient';
    }


}
