<?php

namespace DSL\DSLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DietRulesType extends AbstractType {

    const BLANK_MSG = 'Pole nie może być puste';
    const INVALID_NUM_MSG = 'Podana wartość musi być liczbą';
    const GREATER_THAN_ZERO_MSG = 'Pole musi być większe od zera';
    const MAX_LENGTH_NAME_MSG = 'Pole może zawierać maksymalnie 100 znaków';
    const MAX_LENGTH_DESC_MSG = 'Pole może zawierać maksymalnie 3000 znaków';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
//        $mealRepository = $this->getDoctrine()->getRepository('DSLBundle:Meal');
////        $meals = $mealRepository-> findAll();
//        
//        $em = $this->getDoctrine()->getManager();
//
//        $meals = $em->getRepository('DSLBundle:Meal')->findAll();
////        $mealsRepo-> $this->getDoctrine()->getEntityManager()-> getRepository('DSLBundle:Meal')->findAll();
//        $mealNames=[];
//
//        foreach($mealsRepo as $meal){
//            $mealName = $meal->getName();
//            $mealNames[]=$mealName;
//        }
//        var_dump($meals);
//        
        $builder->add('dailyCaloriesRequirementsKcal', NumberType::class, array(
            'required' => false,
            'scale' => 0,
            'constraints' => array(
                new GreaterThan(array(
                        'value' => 0,
                        'message' => self::GREATER_THAN_ZERO_MSG
                    ))
            )
        ))
                ->add('dailyProteinRequirementsG', NumberType::class, array(
            'required' => false,
            'scale' => 0,
            'constraints' => array(
                new GreaterThan(array(
                        'value' => 0,
                        'message' => self::GREATER_THAN_ZERO_MSG
                    ))
            )
        ))
                ->add('dailyCarbohydratesRequirementsG', NumberType::class, array(
            'required' => false,
            'scale' => 0,
            'constraints' => array(
                new GreaterThan(array(
                        'value' => 0,
                        'message' => self::GREATER_THAN_ZERO_MSG
                    ))
            )
        ))
                ->add('dailyFatRequirementsG', NumberType::class, array(
            'required' => false,
            'scale' => 0,
            'constraints' => array(
                new GreaterThan(array(
                        'value' => 0,
                        'message' => self::GREATER_THAN_ZERO_MSG
                    ))
            )
        ))
                ->add('monthlyCost', NumberType::class, array(
                    'required' => false,
                    'scale' => 0,
                    'constraints' => array(
                        new GreaterThan(array(
                            'value' => 0,
                            'message' => self::GREATER_THAN_ZERO_MSG
                                ))
                    )
                ))
                ->add('whichMeal', EntityType::class, array(
                    'class' => 'DSLBundle:Meal',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('meal')
                                ->orderBy('meal.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'required' => false,
                    'placeholder' => 'Wybierz posiłek',
                    'empty_data' => null))
                ->add('whichProduct', EntityType::class, array(
                    'class' => 'DSLBundle:Product',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('product')
                                ->orderBy('product.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'required' => false,
                    'placeholder' => 'wybierz produkt',
                    'empty_data' => null))
                ->add('repetition')
                ->add('inInterval')
                ->add('base', ChoiceType::class, array(
                    'choices' => array(
                        0 => 'Baza podstawowa',
                        1 => 'Biedronka',
                        2 => 'Lidl'
                    ),
                    'placeholder' => 'Wybierz bazę posiłków',
                    'expanded' => true,
                    'multiple' => false,
                    'choice_attr' => function($value, $key, $index) {
                        if ($key != 0) {
                            return [
                                'class' => 'condition-four',
                                'disabled' => 'disabled'
                            ];
                        } else {
                            return ['class' => 'condition-four'];
                        }
                    }
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DSL\DSLBundle\Entity\DietRules'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'dsl_dslbundle_diet_rules';
    }

}
