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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use DSL\DSLBundle\Form\PeriodicityType;

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
                ->add('periodicities', CollectionType::class, [
                    'entry_type' => PeriodicityType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ])
                            ;
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
