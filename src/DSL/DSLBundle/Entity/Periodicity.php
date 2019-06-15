<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DSL\DSLBundle\Entity\Meal;
use DSL\DSLBundle\Entity\Product;
use DSL\DSLBundle\Entity\DietRules;

/**
 * Periodity
 *
 * @ORM\Table(name="periodicity")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\PeriodicityRepository")
 */
class Periodicity
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="periodicities")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="periodicities")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id") 
     */
    private $meal;

    /**
     * @ORM\ManyToOne(targetEntity="DietRules")
     * @ORM\JoinColumn(name="dietRules_id", referencedColumnName="id")
     */
    private $dietRule;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="cycle", type="integer", nullable=false)
     */
    private $cycle;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setMeal(Meal $meal = null)
    {
        $this->meal = $meal;

        return $this;
    }

    public function getMeal()
    {
        return $this->meal;
    }

    /**
     * Set dietRule.
     *
     * @param int $dietRule
     *
     * @return Periodity
     */
    public function setDietRule($dietRule)
    {
        $this->dietRule = $dietRule;

        return $this;
    }

    /**
     * Get dietRule.
     *
     * @return int
     */
    public function getDietRule()
    {
        return $this->dietRule;
    }
    
    public function setCycle(int $cycle)
    {
        $this->cycle = $cycle;
        
        return $this;
    }
    
    public function getCycle()
    {
        return $this->cycle;
    }
}
