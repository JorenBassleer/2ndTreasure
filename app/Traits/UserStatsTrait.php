<?php

namespace App\Traits;

trait UserStatsTrait
{      
  // Add Treasures to user acc + update user stat
    protected function addUserStats($user, $goodiebag)
    {
      // Add treasures to user's row
      $user->treasures += $goodiebag->treasures;
      // Check if user has row in UserStats
      if($user->userstat != null) {
          // Add amount of kg's donated to stats table
          $user->userstat->total_amount_of_kg_donated += $goodiebag->total_kg;
          // Check if users treasures amount is higher now than in DB
          if($user->userstat->highest_number_of_treasures == null) {
              $user->userstat->highest_number_of_treasures = $user->treasures;
            }
          if($user->userstat->highest_number_of_treasures < $user->treasures) {
            $user->userstat->highest_number_of_treasures = $user->treasures;
          }
          $user->userstat->save();
      }
      else {
          // ADD to userstats
          $user->userstat()->create([
            'total_amount_of_kg_donated' =>  $goodiebag->total_kg,
            'highest_number_of_treasures' => $goodiebag->treasures,
            ]);
      }
      $user->save();
    }
}