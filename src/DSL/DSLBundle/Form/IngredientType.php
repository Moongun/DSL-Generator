<?php

namespace DSL\DSLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThan;

class IngredientType extends AbstractType {

    const BLANK_MSG             = 'Pole nie może być puste';
    const INVALID_NUM_MSG       = 'Podana wartość musi być liczbą';
    const GREATER_THAN_ZERO_MSG = 'Pole musi być większe od zera';
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('quantity', NumberType::class, array(
                    'required'          => false,
                    'invalid_message'   => self::INVALID_NUM_MSG,
                    'constraints'       => array(
                        new NotBlank(array(
                            'message' => self::BLANK_MSG
                            )),
                        new GreaterThan(array(
                            'value' => 0,
                            'message'   => self::GREATER_THAN_ZERO_MSG
                        ))
                        )
                    ))
                ->add('product', null, array(
                    'required'      => false,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message' => self::BLANK_MSG
                            ))
                        )
                    ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DSL\DSLBundle\Entity\Ingredient',
            'mealId' => null,
            'meal' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'dsl_dslbundle_ingredient';
    }

}
