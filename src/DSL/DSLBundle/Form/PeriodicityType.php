<?php

namespace DSL\DSLBundle\Form;

use PHPUnit\Framework\Constraint\LessThan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PeriodicityType extends AbstractType
{
    const START_DAY_TITLE = 'Podaj dzień diety od którego ma zacząć się cykl.';
    const START_DAY_INVALID_MESSAGE = 'Wartość początkowa dla tego warunku musi być liczbą';
    const START_DAY_LESS_THAN_OR_EQUAL_MESSAGE = 'Wartość początkowa musi być mniejsza lub równa 30';
    const START_DAY_GREATER_THAN_MESSAGE = 'Wartość początkowa musi być większa niż 0';

    const CYCLE_TITLE = 'Zdefiniuj co ile dni mają powtórzyć się wybrane pozycje';
    const CYCLE_INVALID_MESSAGE = 'Wartość cyklu dla tego warunku musi być liczbą';
    const CYCLE_LESS_THAN_OR_EQUAL_MESSAGE = 'Wartość cyklu musi być mniejsza lub równa 30';
    const CYCLE_GREATER_THAN_MESSAGE = 'Wartość cyklu musi być większa niż 0';

    const MEAL_PLACEHOLDER = 'posiłek...';

    const PRODUCT_PLACEHOLDER = 'produkt...';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('startDay', NumberType::class, array(
                    'required'      => true,
                    'attr'  => [
                        'title' => self::START_DAY_TITLE
                    ],
                    'invalid_message' => self::START_DAY_INVALID_MESSAGE,
                    'constraints'   => [
                        new LessThanOrEqual([
                            'value' => 30,
                            'message' => self::START_DAY_LESS_THAN_OR_EQUAL_MESSAGE,
                        ]),
                        new GreaterThan([
                            'value' => 0,
                            'message' => self::START_DAY_GREATER_THAN_MESSAGE
                        ])
                    ]
                ))
                ->add('cycle', NumberType::class, array(
                    'required'      => true,
                    'attr' => [
                        'title' => self::CYCLE_TITLE,
                    ],
                    'invalid_message' => self::CYCLE_INVALID_MESSAGE,
                    'constraints'   => [
                        new LessThanOrEqual([
                            'value' => 30,
                            'message' => self::CYCLE_LESS_THAN_OR_EQUAL_MESSAGE,
                        ]),
                        new GreaterThan([
                            'value' => 0,
                            'message' => self::CYCLE_GREATER_THAN_MESSAGE,
                        ])
                    ]
                ))
                ->add('meal', EntityType::class, array(
                    'class'         => 'DSLBundle:Meal',
                    'choice_label'  => 'name',
                    'placeholder' => self::MEAL_PLACEHOLDER,
                    'required' => false
                ))
                ->add('product', EntityType::class, array(
                    'class'      => 'DSLBundle:Product',
                    'choice_label'  => 'name',
                    'placeholder' => self::PRODUCT_PLACEHOLDER,
                    'required' => false
                ))
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DSL\DSLBundle\Entity\Periodicity'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dsl_dslbundle_periodicity';
    }


}
