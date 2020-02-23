<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Meal
 *
 * @ORM\Table(name="meal")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\MealRepository")
 */
class Meal
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="energy_kcal", type="integer")
     */
    private $energyKcal;

    /**
     * @var int
     *
     * @ORM\Column(name="protein_g", type="float")
     */
    private $proteinG;

    /**
     * @var float
     *
     * @ORM\Column(name="carbohydrates_g", type="float")
     */
    private $carbohydratesG;

    /**
     * @var float
     *
     * @ORM\Column(name="fat_g", type="float")
     */
    private $fatG;

    /**
     * @var float
     *
     * @ORM\Column(name="average_cost", type="decimal", precision=10, scale=2)
     */
    private $averageCost;
    
    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="meal", cascade={"persist"})
     * @var type 
     */
    private $ingredients;
    
    /**
     * @ORM\OneToMany(targetEntity="CreatedDiet", mappedBy="meal")
     * @var type 
     */
    private $createdDiet;
    
    /**
     * @ORM\OneToMany(targetEntity="Periodicity", mappedBy="meal")
     */
    private $periodicities;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Meal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Meal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Meal
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set energyKcal
     *
     * @param integer $energyKcal
     * @return Meal
     */
    public function setEnergyKcal($energyKcal)
    {
        $this->energyKcal = $energyKcal;

        return $this;
    }

    /**
     * Get energyKcal
     *
     * @return integer 
     */
    public function getEnergyKcal()
    {
        return $this->energyKcal;
    }

    /**
     * Set proteinG
     *
     * @param integer $proteinG
     * @return Meal
     */
    public function setProteinG($proteinG)
    {
        $this->proteinG = $proteinG;

        return $this;
    }

    /**
     * Get proteinG
     *
     * @return integer 
     */
    public function getProteinG()
    {
        return $this->proteinG;
    }

    /**
     * Set carbohydratesG
     *
     * @param integer $carbohydratesG
     * @return Meal
     */
    public function setCarbohydratesG($carbohydratesG)
    {
        $this->carbohydratesG = $carbohydratesG;

        return $this;
    }

    /**
     * Get carbohydratesG
     *
     * @return integer 
     */
    public function getCarbohydratesG()
    {
        return $this->carbohydratesG;
    }

    /**
     * Set fatG
     *
     * @param integer $fatG
     * @return Meal
     */
    public function setFatG($fatG)
    {
        $this->fatG = $fatG;

        return $this;
    }

    /**
     * Get fatG
     *
     * @return integer 
     */
    public function getFatG()
    {
        return $this->fatG;
    }

    /**
     * Set averageCost
     *
     * @param float $averageCost
     * @return Meal
     */
    public function setAverageCost($averageCost)
    {
        $this->averageCost = $averageCost;

        return $this;
    }

    /**
     * Get averageCost
     *
     * @return float 
     */
    public function getAverageCost()
    {
        return $this->averageCost;
    }

    /**
     * Add ingredients
     *
     * @param \DSL\DSLBundle\Entity\Ingredient $ingredients
     * @return Meal
     */
    public function addIngredient(Ingredient $ingredient)
    {
        if (!$this->ingredients->contains($ingredient)) {
            $ingredient->setMeal($this);
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \DSL\DSLBundle\Entity\Ingredient $ingredients
     */
    public function removeIngredient(\DSL\DSLBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Add createdDiet
     *
     * @param \DSL\DSLBundle\Entity\CreatedDiet $createdDiet
     * @return Meal
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
    
    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
   // to show the name of the Category in the select
    return $this->name;
   // to show the id of the Category in the select
   // return $this->id;
    }
    
}
