<?php

namespace App\Traits;
use App\Food;
trait AddFoodToGoodiebagTrait
{
    protected function addFoodToGoodiebag($goodiebag,$foods)
    {

        if($this->containsOnlyNullOrZero($foods)) {
            return false;
        }
        foreach($foods as $food => $amount) {
            // Don't allow null in DB
            if($amount !=null) {
                // Check if submitted amount is a number
                if(!is_numeric($amount)) {
                    return false;
                }
                // Stops a bunch of rows where value = 0
                if($amount != 0) {
                    // Search id of food
                    $foodDb = Food::where('type', $food)->first();
                    // add id and amount to array -> so we don't create an unsuccessful goodiebag
                    $goodiebag->foods()->attach($foodDb->id, ['amount' => $amount]);
                    // Get submitted amount of food
                    // Get avg food weight if food value isn't submitted in grams
                    if($food == 'fish' || $food == 'meat' || $food == 'body_care' || $food == 'other') {
                        // Calculate treasures first since if meat/fish
                        // we convert it to kg
                        $treasures = $this->calculateAction($food, $amount, 'value');
                        // Add to total weight of food weight
                        // Check if meat or fish since submitted amount
                        // is in g
                        if($food == 'fish' || $food == 'meat') {
                            $amount = $amount / 1000;
                        }
                        $goodiebag->treasures += $treasures;
                        $goodiebag->total_kg += $amount;
                    }
                    else {
                        $foodWeight = $this->calculateAction($food, $amount, 'avgWeightPer');
                        $treasures = $this->calculateAction($food, $amount, 'value');
                        // Add to total weight of food weight
                        $goodiebag->total_kg += $foodWeight;
                        $goodiebag->treasures += $treasures;
                    }
                }
            }
        }
        $goodiebag->save();
        return true;
    }

    public function containsOnlyNullOrZero($input)
    {
        // Go through array and filter the null and zero out
        // If array is empty -> user didn't give valid values
        return empty(array_filter($input, function ($a) { 
            if($a !== null && $a !== 0) {
                return $a;
            }
        }));
    }

    protected function calculateAction($foodName, $amount, $action)
    {
        $food = Food::where('type', $foodName)->first();
        // Get the average action
        $actionEach = $food->$action;
        // Multiply with amount submitted
        $actionAmount = $actionEach * $amount;

        return $actionAmount;
    }
}