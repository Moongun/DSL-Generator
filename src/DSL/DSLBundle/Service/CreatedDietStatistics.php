<?php
namespace DSL\DSLBundle\Service;


class CreatedDietStatistics
{
    const DAILY_AVG_FATS = 'daily_average_fats';
    const DAILY_AVG_CARBOHYDRATES = 'daily_average_carbohydrates';
    const DAILY_AVG_PROTEINS = 'daily_average_proteins';
    const DAILY_AVG_ENERGY = 'daily_average_energy';
    const MONTHLY_COST = 'monthly_cost';
    const WEEK_ONE_COST = 'week_one_cost';
    const WEEK_TWO_COST = 'week_two_cost';
    const WEEK_THREE_COST = 'week_three_cost';
    const WEEK_FOUR_COST = 'week_four_cost';
    const WEEK_FIVE_COST = 'week_five_cost';

    private $data;
    private $statistics;

    public function setData(array $data) {
        $this->data = $data;

        return $this;
    }

    private function init() {
        return [
            self::DAILY_AVG_FATS => 0,
            self::DAILY_AVG_CARBOHYDRATES => 0,
            self::DAILY_AVG_PROTEINS => 0,
            self::DAILY_AVG_ENERGY => 0,
            self::MONTHLY_COST => 0,
            self::WEEK_ONE_COST => 0,
            self::WEEK_TWO_COST => 0,
            self::WEEK_THREE_COST => 0,
            self::WEEK_FOUR_COST => 0,
            self::WEEK_FIVE_COST => 0,
        ];
    }

    private function prepare() {
        $statistics = $this->init();

        foreach($this->data as $data) {
            $meal = $data->getMeal();
            $statistics[self::DAILY_AVG_FATS] += $meal->getFatG();
            $statistics[self::DAILY_AVG_CARBOHYDRATES] += $meal->getCarbohydratesG();
            $statistics[self::DAILY_AVG_PROTEINS] += $meal->getProteinG();
            $statistics[self::DAILY_AVG_ENERGY] += $meal->getEnergyKcal();
            $averageCost = $meal->getAverageCost();
            $statistics[self::MONTHLY_COST] += $averageCost;

            $day = $data->getDay();
            if($day <= 7) {
                $statistics[self::WEEK_ONE_COST] += $averageCost;
            } elseif ($day <=14) {
                $statistics[self::WEEK_TWO_COST] += $averageCost;
            } elseif ($day <= 21) {
                $statistics[self::WEEK_THREE_COST] += $averageCost;
            } elseif ($day <= 28) {
                $statistics[self::WEEK_FOUR_COST] += $averageCost;
            } elseif ($day <= 30) {
                $statistics[self::WEEK_FIVE_COST] += $averageCost;
            } else {
                throw new \Exception('There is more than 30 days');
            }
        };

        $statistics[self::DAILY_AVG_FATS] = $statistics[self::DAILY_AVG_FATS] / 30;
        $statistics[self::DAILY_AVG_CARBOHYDRATES] = $statistics[self::DAILY_AVG_CARBOHYDRATES] / 30;
        $statistics[self::DAILY_AVG_PROTEINS] = $statistics[self::DAILY_AVG_PROTEINS] / 30;
        $statistics[self::DAILY_AVG_ENERGY] = $statistics[self::DAILY_AVG_ENERGY] / 30;

        $this->statistics = $statistics;
    }

    public function getStatistics() {
        $this->prepare();
        return $this->statistics;
    }
}
