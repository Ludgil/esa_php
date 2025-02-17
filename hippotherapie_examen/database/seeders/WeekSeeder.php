<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Week;
use Illuminate\Database\Seeder;

class WeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = "2025";
        $startOfYear = Carbon::create($year, 1, 1);

        if(!$startOfYear->isMonday()){
            $startOfYear->next(Carbon::MONDAY);
        }

        $currentDate = $startOfYear;
        // utilisation d'une variable intermédiaire pour la semaine, car si je doit faire reculer la semaine
        // si j'utilise l'objet $currentdDate, la date complete recule avec la semaine
        $weekOfYear = $currentDate->weekOfYear;

        if($weekOfYear > 1){
            --$weekOfYear;
        }

        while ($currentDate->year == $year) {
            Week::create([
                'week_number' => $weekOfYear++,
                'year' => $currentDate->year, 
                'start_date' => $currentDate->toDateString(),
                'end_date' => $currentDate->copy()->addDays(6)->toDateString(),
            ]);

            $currentDate->addWeek();
        }
    }
}
