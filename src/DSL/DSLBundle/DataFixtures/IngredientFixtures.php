<?php
namespace DSL\DSLBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DSL\DSLBundle\DataFixtures\MealFixtures;
use DSL\DSLBundle\DataFixtures\ProductFixtures;
use Doctrine\ORM\EntityManager;
use DSL\DSLBundle\Entity\Meal;
use DSL\DSLBundle\Entity\Product;
use DSL\DSLBundle\Entity\Ingredient;

class IngredientFixtures extends Fixture
{
    private $entityManager;
    
    public function __construct(EntityManager $entityManager
        ) {
        $this->entityManager = $entityManager;
    }
    
    public function load (ObjectManager $manager)
    {
        $meals = $this->entityManager->getRepository(Meal::class)->findAll();
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        
        foreach ($meals as $meal) {
            for ($i = 1; $i <= 3; $i++) {
                $randomProduct = array_rand($products);
                
                $ingredient = new Ingredient();
                $ingredient->setProduct($products[$randomProduct]);
                $ingredient->setQuantity(mt_rand(1,3));

                $meal->addIngredient($ingredient);
                $manager->persist($meal);
            }
        }
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return array(
            MealFixtures::class,
            ProductFixtures::class
        );
    }
}
