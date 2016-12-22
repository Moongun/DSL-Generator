<?php

namespace DSL\DSLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient")
 * @ORM\Entity(repositoryClass="DSL\DSLBundle\Repository\IngredientRepository")
 */
class Ingredient
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
     * @ORM\Column(name="meal_id", type="integer")
     */
    private $mealId;

    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="ingredients")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id")
     * @var type 
     */
    private $meal;
    
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="ingredients")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @var type 
     */
    private $product;


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
     * Set mealId
     *
     * @param integer $mealId
     * @return Ingredient
     */
    public function setMealId($mealId)
    {
        $this->mealId = $mealId;

        return $this;
    }

    /**
     * Get mealId
     *
     * @return integer 
     */
    public function getMealId()
    {
        return $this->mealId;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     * @return Ingredient
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Ingredient
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set meal
     *
     * @param \DSL\DSLBundle\Entity\Meal $meal
     * @return Ingredient
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

    /**
     * Set product
     *
     * @param \DSL\DSLBundle\Entity\Product $product
     * @return Ingredient
     */
    public function setProduct(\DSL\DSLBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \DSL\DSLBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
