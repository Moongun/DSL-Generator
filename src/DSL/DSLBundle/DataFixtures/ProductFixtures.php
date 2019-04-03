<?php
namespace DSL\DSLBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DSL\DSLBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $countable = ['tak', 'nie'];
        
        for ($i = 1; $i<= 20; $i++)
        {
            $product = new Product();
            $product->setName('product_' . $i);
            $product->setAveragePrice(mt_rand(1,10));
            $product->setCountable($countable[mt_rand(0, count($countable)-1)]);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
