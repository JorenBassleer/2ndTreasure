<?php

use Illuminate\Database\Seeder;
use App\Foodbank;
use Illuminate\Support\Facades\Hash;
class FoodbanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Foodbank::create([
            'user_id' => 2,
            'company_number' => 'BE54 0001 0968 7697',
            'details' => 'De vzw Daklozenhulp Antwerpen heeft als doel concrete hulp te bieden aan mensen uit Antwerpen en omstreken die om welke reden dan ook op of onder de armoedegrens leven en daardoor soms onvoldoende middelen (over)hebben om voldoende voedsel te kunnen kopen. De organisatie stelt zich slechts als doel om via een wekelijkse voedselbedeling een kwalitatieve aanvulling te bieden. Hoewel dit misschien een weinig ophefmakende of ambitieuze doelstelling lijkt, merken we wekelijks hoe honger en/of sociaal isolement een vernietigend effect kan hebben op mensen, die het reeds moeilijk hebben.',
            'website' => 'http://www.daklozenhulpantwerpen.be/',
        ]);
        Foodbank::create([
            'user_id' => 3,
            'company_number' => 'BE54 401 0968 7697',
        ]);
    }
}
