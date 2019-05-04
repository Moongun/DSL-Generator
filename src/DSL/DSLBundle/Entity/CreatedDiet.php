<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CreatedDiet
 *
 * @ORM\Table(name="created_diet")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\CreatedDietRepository")
 */
class CreatedDiet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="integer")
     */
    private $day;
    
    /**
     * @ORM\ManyToOne(targetEntity="DietRules", inversedBy="createdDiet")
     * @ORM\JoinColumn(name="dietRules_id", referencedColumnName="id")
     * @var type 
     */
    private $dietRules;
    
    /**
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="createdDiet")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id")
     * @var type 
     */
    private $meal;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set day
     *
     * @param integer $day
     * @return this
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set dietRules
     *
     * @param \DSL\DSLBundle\Entity\DietRules $dietRules
     * @return CreatedDiet
     */
    public function setDietRules(\DSL\DSLBundle\Entity\DietRules $dietRules)
    {
        $this->dietRules = $dietRules;

        return $this;
    }

    /**
     * Get dietRules
     *
     * @return \DSL\DSLBundle\Entity\DietRules 
     */
    public function getDietRules()
    {
        return $this->dietRules;
    }

    /**
     * Set meal
     *
     * @param \DSL\DSLBundle\Entity\Meal $meal
     * @return CreatedDiet
     */
    public function setMeal(\DSL\DSLBundle\Entity\Meal $meal)
    {
        $this->meal = $meal;

        return $this;
    }

    /**
     * Get meal
     *
     * @return \DSL\DSLBundle\Entity\Meal 
     */
    public function getMeal()
    {
        return $this->meal;
    }
}
