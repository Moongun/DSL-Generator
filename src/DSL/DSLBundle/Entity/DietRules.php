<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DSL\DSLBundle\Entity\Periodicity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * diet_rules
 *
 * @ORM\Table(name="diet_rules")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\DietRulesRepository")
 */
class DietRules
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
     *
     * @var int
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    private $user;

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
     * @ORM\OneToMany(targetEntity="CreatedDiet", mappedBy="dietRules", cascade={"remove"}, fetch="EAGER")
     * @var type 
     */
    private $createdDiet;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="created_date", type="date")
     */
    private $createdDate;
    
    /**
     * @ORM\OneToMany(targetEntity="Periodicity", mappedBy="dietRule", cascade={"persist", "remove"})
     */
    private $periodicities;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdDiet = new ArrayCollection();
        $this->createdDate = new \DateTime;
        $this->periodicities = new ArrayCollection();
    }
    
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
     * Get user
     *
     * @return integer 
     */
    function getUser() {
        return $this->user;
    }

    /**
     * Set user
     *
     * @return integer 
     */
    function setUser($user) {
        $this->user = $user;
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
    
    public function addPeriodicity(Periodicity $periodicity)
    {
        if (!$this->periodicities->contains($periodicity)) {
            $periodicity->setDietRule($this);
            $this->periodicities->add($periodicity);
        }

        return $this;
    }

    public function removePeriodicity(Periodicity $periodicity)
    {
        $this->periodicities->removeElement($periodicity);
    }
    
    public function getPeriodicities()
    {
        return $this->periodicities;
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
    
    /**
     * get createdDate
     * 
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Check if entity has data for periodicity rule.
     *
     * @return bool
     */
    public function hasPeriodicityRule()
    {
        return $this->periodicities->isEmpty() ? false : true;
    }

    /**
     * Check if entity has data for financial rule.
     *
     * @return bool
     */
    public function hasFinancialRule()
    {
        return $this->getMonthlyCost() ? true : false;
    }

    /**
     * Check if entity has data for composition rule.
     *
     * @return bool
     */
    public function hasCompositionRule()
    {
        if ($this->getDailyCaloriesRequirementsKcal() ||
            $this->getDailyProteinRequirementsG() ||
            $this->getDailyCarbohydratesRequirementsG() ||
            $this->getDailyFatRequirementsG()
        ) {
            return true;
        }
        return false;
    }

    /**
     * Returns array with names of active rules.
     *
     * @return array
     */
    public function getActiveRules()
    {
        return [
            'composition' => $this->hasCompositionRule(),
            'financial' => $this->hasFinancialRule(),
            'periodicity' => $this->hasPeriodicityRule()
        ];
    }
}
