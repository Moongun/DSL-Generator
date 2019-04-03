<?php
namespace DSL\DSLBundle\Service;

use DSL\DSLBundle\Repository\MealRepository;
use DSL\DSLBundle\Service\dailyRequirements\Energy;
use Doctrine\ORM\EntityManager;

class MealReplacer {
//    private $rule;
    private $mealRepository;
    private $em;
    
    public function __construct(MealRepository $mealRepository, EntityManager $em) 
    {
        $this->mealRepository = $mealRepository;
        $this->em = $em;
    }
    
    public function replace(string $target, string $limit)
    {
        $stm = $this->em->createQuery('SELECT meal FROM DSLBundle:Meal meal WHERE meal.type = :type and meal.energyKcal <= :value * ' . $limit . '/100');
        $breakfast = $stm->setParameters(['type' => 'śniadanie', 'value' => Energy::BREAKFAST])->setMaxResults(1)->getResult();
        $brunch = $stm->setParameters(['type' => 'brunch', 'value' => Energy::BRUNCH])->setMaxResults(1)->getResult();
        $lunch = $stm->setParameters(['type' => 'lunch', 'value' => Energy::LUNCH])->setMaxResults(1)->getResult();
        $dinner = $stm->setParameters(['type' => 'obiad', 'value' => Energy::DINNER])->setMaxResults(1)->getResult();
        $supper = $stm->setParameters(['type' => 'kolacja', 'value'=> Energy::SUPPER])->setMaxResults(1)->getResult();
        dump($breakfast, $brunch, $lunch, $supper, $dinner);
    }
}
