<?php

namespace DSL\DSLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MealType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('description')
                ->add('type')
                ->add('energyValueKcal')
                ->add('proteinG')
                ->add('carbohydratesG')
                ->add('fatG')
                ->add('averageCost')
                ->add('base', ChoiceType::class, array(
                    'choices' => array(
                        0 => 'Baza podstawowa',
                        1 => 'Biedronka',
                        2 => 'Lidl'
                    ),
                    'placeholder' => 'Wybierz bazę posiłków',
                    'expanded' => false,
                    'multiple' => false,
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSL\DSLBundle\Entity\Meal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dsl_dslbundle_meal';
    }


}
