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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Diet_rules", inversedBy="createdDiet")
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;
    
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
     * Set date
     *
     * @param \DateTime $date
     * @return CreatedDiet
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dietRules
     *
     * @param \DSL\DSLBundle\Entity\Diet_rules $dietRules
     * @return CreatedDiet
     */
    public function setDietRules(\DSL\DSLBundle\Entity\Diet_rules $dietRules = null)
    {
        $this->dietRules = $dietRules;

        return $this;
    }

    /**
     * Get dietRules
     *
     * @return \DSL\DSLBundle\Entity\Diet_rules 
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
    public function setMeal(\DSL\DSLBundle\Entity\Meal $meal = null)
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
  
    function getUserId() {
        return $this->userId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }




}
