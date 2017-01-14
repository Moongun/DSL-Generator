<?php

namespace DSL\DSLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class diet_rulesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dailyCaloriesRequirementsKcal')
                ->add('dailyProteinRequirementsG')
                ->add('dailyCarbohydratesRequirementsG')
                ->add('dailyFatRequirementsG')
                ->add('monthlyCost')
                ->add('whichMeal', EntityType::class, array(
                    'class'=>'DSLBundle:Meal',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('meal')
                            ->orderBy('meal.name', 'ASC');
                },
                    'choice_label'=>'name',
                    'required'=>false,
                    'placeholder' => 'Choose meal',
                    'empty_data'  => null))
                ->add('whichProduct', EntityType::class, array(
                    'class'=>'DSLBundle:Product', 
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('product')
                            ->orderBy('product.name', 'ASC');
                },
                    'choice_label'=>'name',
                    'required'=>false,
                    'placeholder' => 'Choose product',
                    'empty_data'  => null))
                ->add('repetition')
                ->add('inInterval')        ;
    }

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSL\DSLBundle\Entity\diet_rules'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dsl_dslbundle_diet_rules';
    }


}
