<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * diet_rules
 *
 * @ORM\Table(name="diet_rules")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\Diet_rulesRepository")
 */
class Diet_rules
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
     * @ORM\Column(name="daily_calories_requirements_kcal", type="integer", nullable=true)
     */
    private $dailyCaloriesRequirementsKcal;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_protein_requirements_g", type="integer", nullable=true)
     */
    private $dailyProteinRequirementsG;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_carbohydrates_requirements_g", type="integer", nullable=true)
     */
    private $dailyCarbohydratesRequirementsG;
    
    /**
     * @var int
     *
     * @ORM\Column(name="daily_fat_requirements_g", type="integer", nullable=true)
     */
    private $dailyFatRequirementsG;

    /**
     * @var float
     *
     * @ORM\Column(name="monthly_cost", type="float", nullable=true)
     */
    private $monthlyCost;

    /**
     * @var string
     *
     * @ORM\Column(name="which_meal", type="string", length=255, nullable=true)
     */
    private $whichMeal;

    /**
     * @var string
     *
     * @ORM\Column(name="which_product", type="string", length=255, nullable=true)
     */
    private $whichProduct;

    /**
     * @var int
     *
     * @ORM\Column(name="repetition", type="integer", nullable=true)
     */
    private $repetition;

    /**
     * @var int
     *
     * @ORM\Column(name="in_interval", type="integer", nullable=true)
     */
    private $inInterval;
    
    /**
     * @ORM\OneToMany(targetEntity="CreatedDiet", mappedBy="dietRules")
     * @var type 
     */
    private $createdDiet;


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
     * Set dailyCaloriesRequirementsKcal
     *
     * @param integer $dailyCaloriesRequirementsKcal
     * @return diet_rules
     */
    public function setDailyCaloriesRequirementsKcal($dailyCaloriesRequirementsKcal)
    {
        $this->dailyCaloriesRequirementsKcal = $dailyCaloriesRequirementsKcal;

        return $this;
    }

    /**
     * Get dailyCaloriesRequirementsKcal
     *
     * @return integer 
     */
    public function getDailyCaloriesRequirementsKcal()
    {
        return $this->dailyCaloriesRequirementsKcal;
    }

    /**
     * Set dailyProteinRequirementsG
     *
     * @param integer $dailyProteinRequirementsG
     * @return diet_rules
     */
    public function setDailyProteinRequirementsG($dailyProteinRequirementsG)
    {
        $this->dailyProteinRequirementsG = $dailyProteinRequirementsG;

        return $this;
    }

    /**
     * Get dailyProteinRequirementsG
     *
     * @return integer 
     */
    public function getDailyProteinRequirementsG()
    {
        return $this->dailyProteinRequirementsG;
    }

    /**
     * Set dailyCarbohydratesRequirementsG
     *
     * @param integer $dailyCarbohydratesRequirementsG
     * @return diet_rules
     */
    public function setDailyCarbohydratesRequirementsG($dailyCarbohydratesRequirementsG)
    {
        $this->dailyCarbohydratesRequirementsG = $dailyCarbohydratesRequirementsG;

        return $this;
    }
    
    /**
     * Get dailyFatRequirementsG
     *
     * @return integer 
     */
    function getDailyFatRequirementsG() {
        return $this->dailyFatRequirementsG;
    }
    
    /**
     * Set dailyFatRequirementsG
     *
     * @param integer $dailyFatRequirementsG
     * @return diet_rules
     */
    function setDailyFatRequirementsG($dailyFatRequirementsG) {
        $this->dailyFatRequirementsG = $dailyFatRequirementsG;
    }

        /**
     * Get dailyCarbohydratesRequirementsG
     *
     * @return integer 
     */
    public function getDailyCarbohydratesRequirementsG()
    {
        return $this->dailyCarbohydratesRequirementsG;
    }

    /**
     * Set monthlyCost
     *
     * @param float $monthlyCost
     * @return diet_rules
     */
    public function setMonthlyCost($monthlyCost)
    {
        $this->monthlyCost = $monthlyCost;

        return $this;
    }

    /**
     * Get monthlyCost
     *
     * @return float 
     */
    public function getMonthlyCost()
    {
        return $this->monthlyCost;
    }

    /**
     * Set whichMeal
     *
     * @param string $whichMeal
     * @return diet_rules
     */
    public function setWhichMeal($whichMeal)
    {
        $this->whichMeal = $whichMeal;

        return $this;
    }

    /**
     * Get whichMeal
     *
     * @return string 
     */
    public function getWhichMeal()
    {
        return $this->whichMeal;
    }

    /**
     * Set whichProduct
     *
     * @param string $whichProduct
     * @return diet_rules
     */
    public function setWhichProduct($whichProduct)
    {
        $this->whichProduct = $whichProduct;

        return $this;
    }

    /**
     * Get whichProduct
     *
     * @return string 
     */
    public function getWhichProduct()
    {
        return $this->whichProduct;
    }

    /**
     * Set repetition
     *
     * @param integer $repetition
     * @return diet_rules
     */
    public function setRepetition($repetition)
    {
        $this->repetition = $repetition;

        return $this;
    }

    /**
     * Get repetition
     *
     * @return integer 
     */
    public function getRepetition()
    {
        return $this->repetition;
    }

    /**
     * Set inInterval
     *
     * @param string $inInterval
     * @return diet_rules
     */
    public function setInInterval($inInterval)
    {
        $this->inInterval = $inInterval;

        return $this;
    }

    /**
     * Get inInterval
     *
     * @return integer 
     */
    public function getInInterval()
    {
        return $this->inInterval;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDiet = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add createdDiet
     *
     * @param \DSL\DSLBundle\Entity\CreatedDiet $createdDiet
     * @return Diet_rules
     */
    public function addCreatedDiet(\DSL\DSLBundle\Entity\CreatedDiet $createdDiet)
    {
        $this->createdDiet[] = $createdDiet;

        return $this;
    }

    /**
     * Remove createdDiet
     *
     * @param \DSL\DSLBundle\Entity\CreatedDiet $createdDiet
     */
    public function removeCreatedDiet(\DSL\DSLBundle\Entity\CreatedDiet $createdDiet)
    {
        $this->createdDiet->removeElement($createdDiet);
    }

    /**
     * Get createdDiet
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedDiet()
    {
        return $this->createdDiet;
    }
}
