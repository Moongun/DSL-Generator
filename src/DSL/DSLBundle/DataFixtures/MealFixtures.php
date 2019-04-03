<?php
namespace DSL\DSLBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DSL\DSLBundle\Entity\Meal;

class MealFixtures extends Fixture
{
    const BREAKFAST  = 'śniadanie';
    const BRUNCH     = 'brunch';
    const LUNCH      = 'lunch';
    const DINNER     = 'obiad';
    const SUPPER     = 'kolacja';
    
    public function load(ObjectManager $manager)
    {
        $this->prepareTypeSet(self::BREAKFAST, $manager);
        $this->prepareTypeSet(self::BRUNCH, $manager);
        $this->prepareTypeSet(self::LUNCH, $manager);
        $this->prepareTypeSet(self::DINNER, $manager);
        $this->prepareTypeSet(self::SUPPER, $manager);
    }
    
    private function prepareTypeSet($set, $manager)
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at arcu placerat, euismod urna ac, molestie tortor. Duis consequat odio nulla. Suspendisse efficitur commodo nisi vitae scelerisque. Phasellus sagittis finibus diam at vulputate. Sed fringilla vestibulum aliquam. Morbi finibus quam risus, in semper turpis egestas sit amet. Nulla efficitur ultricies magna eget semper. Integer sagittis non sem eget commodo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce auctor dui arcu, at varius nisl porta non. Sed sit amet dignissim nisi. Sed finibus condimentum sapien, non condimentum quam congue eget. In vulputate mi ac eros fermentum suscipit.';
        
        for ($i = 1; $i<=20; $i++) {
            $meal = new Meal();
            $meal->setName('meal_' .$set . '_' . $i);
            $meal->setDescription($description);
            $meal->setAverageCost(mt_rand(1, 100));
            $meal->setBase(0);
            $meal->setCarbohydratesG(mt_rand(1, 1000));
            $meal->setEnergyKcal(mt_rand(1, 1000));
            $meal->setFatG(mt_rand(1, 1000));
            $meal->setProteinG(mt_rand(1, 1000));
            $meal->setType($set);
            
            $manager->persist($meal);
        }
        
        $manager->flush();
        
        return;
    }
}
