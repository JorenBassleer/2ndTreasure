<?php

namespace App\Traits;
use Illuminate\Http\Request;

trait FoodbankStatsTrait
{
  protected function addFoodbankStats($foodbank, $goodiebag)
  {
      if($foodbank->foodbankstat == null) {
        
          // create one variable since i can't put 1 into the create for some reason
          // No stats of this foodbank yet so create new one
          $one = 1;
          $foodbank->foodbankstat()->create([
              'total_amount_of_kg_received' => $goodiebag->total_kg,
              'total_amount_of_treasures_generated' => $goodiebag->treasures,
              'total_amount_of_goodiebags_received' => $one,
          ]);

      }
      else {
          $foodbank->foodbankstat->total_amount_of_kg_received +=$goodiebag->total_kg;
          $foodbank->foodbankstat->total_amount_of_treasures_generated +=$goodiebag->treasures;
          $foodbank->foodbankstat->total_amount_of_goodiebags_received += 1;
          $foodbank->foodbankstat->save();
      }
  }
}