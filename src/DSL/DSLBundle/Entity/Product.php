<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\ProductsRepository")
 */
class Product
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
     * @var float
     *
     * @ORM\Column(name="average_price", type="decimal", precision=10, scale=2)
     */
    private $averagePrice;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="countable", type="string", length=255) 
     */
    private $countable;
    
    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="product")
     * @var type 
     */
    private $ingredients;


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
     * @return Product
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
     * Set averagePrice
     *
     * @param float $averagePrice
     * @return Product
     */
    public function setAveragePrice($averagePrice)
    {
        $this->averagePrice = $averagePrice;

        return $this;
    }

    /**
     * Get averagePrice
     *
     * @return float 
     */
    public function getAveragePrice()
    {
        return $this->averagePrice;
    }
    
    /**
     * Set $countable
     * 
     * @param type $countable
     */
    public function setCountable($countable)
    {
        $this->countable = $countable;
    }
    
    /**
     * get Countable
     * 
     * @return string
     */
    public function getCountable()
    {
        return $this->countable;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingredients
     *
     * @param \DSL\DSLBundle\Entity\Ingredient $ingredients
     * @return Product
     */
    public function addIngredient(\DSL\DSLBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

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
