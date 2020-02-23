<?php

namespace DSL\DSLBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MealType extends AbstractType
{
    
    const BLANK_MSG             = 'Pole nie może być puste';
    const INVALID_NUM_MSG       = 'Podana wartość musi być liczbą';
    const GREATER_THAN_ZERO_MSG = 'Pole musi być większe od zera';
    const MAX_LENGTH_NAME_MSG   = 'Pole może zawierać maksymalnie 100 znaków';
    const MAX_LENGTH_DESC_MSG   = 'Pole może zawierać maksymalnie 3000 znaków';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
                    'required'      => false,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'       => self::BLANK_MSG
                        )),
                        new Length(array(
                            'max'           => 100,
                            'maxMessage'    => self::MAX_LENGTH_NAME_MSG
                        ))
                    ),
                    'trim'          => true
                ))
                ->add('description', TextAreaType::class, array(
                    'required'      => false,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'       => self::BLANK_MSG
                        )),
                        new Length(array(
                            'max'           => 3000,
                            'maxMessage'    => self::MAX_LENGTH_DESC_MSG
                        ))
                    ),
                    'trim'          => true
                ))
                ->add('type', ChoiceType::class, array(
                    'required'      => false,
                    'choices'       => array(
                        'śniadanie' => 'Śniadanie',
                        'brunch'    => 'Brunch',
                        'lunch'     => 'Lunch',
                        'obiad'     => 'Obiad',
                        'kolacja'   => 'Kolacja'
                    ),
                    'placeholder'   => 'Wybierz typ posiłku',
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'       => self::BLANK_MSG                            
                        ))
                    )
                ))
                ->add('energyKcal', NumberType::class, array(
                    'required'          => false,
                    'invalid_message'   => self::INVALID_NUM_MSG,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'   => self::BLANK_MSG                            
                        )),
                        new GreaterThan(array(
                            'value'     => 0,
                            'message'   => self::GREATER_THAN_ZERO_MSG
                        ))
                    )
                ))
                ->add('proteinG', NumberType::class, array(
                    'required'          => false,
                    'invalid_message'   => self::INVALID_NUM_MSG,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'   => self::BLANK_MSG                            
                        )),
                        new GreaterThan(array(
                            'value'     => 0,
                            'message'   => self::GREATER_THAN_ZERO_MSG
                        ))
                    )
                ))
                ->add('carbohydratesG', NumberType::class, array(
                    'required'          => false,
                    'invalid_message'   => self::INVALID_NUM_MSG,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'   => self::BLANK_MSG                            
                        )),
                        new GreaterThan(array(
                            'value'     => 0,
                            'message'   => self::GREATER_THAN_ZERO_MSG
                        ))
                    )
                ))
                ->add('fatG', NumberType::class, array(
                    'required'          => false,
                    'invalid_message'   => self::INVALID_NUM_MSG,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'   => self::BLANK_MSG                            
                        )),
                        new GreaterThan(array(
                            'value'     => 0,
                            'message'   => self::GREATER_THAN_ZERO_MSG
                        ))
                    )
                ))
                ->add('averageCost', NumberType::class, array(
                    'required'          => false,
                    'invalid_message'   => self::INVALID_NUM_MSG,
                    'constraints'   => array(
                        new NotBlank(array(
                            'message'   => self::BLANK_MSG                            
                        )),
                        new GreaterThan(array(
                            'value'     => 0,
                            'message'   => self::GREATER_THAN_ZERO_MSG
                        ))
                    )
                ))

        ;
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
