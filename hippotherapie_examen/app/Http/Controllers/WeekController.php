<?php

namespace App\Http\Controllers;

use App\Models\Pony;
use App\Models\Week;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\WeekRequest;
use Illuminate\Http\RedirectResponse;

class WeekController extends Controller
{
    //
    public function index(Request $request): View
    {
        $year = now()->year;
        $availableYears = Week::distinct()->orderBy('year', 'asc')->pluck('year');

        if($availableYears){
            $year = $availableYears[0];
        }
        
        $selectedYear = $request->get('year', $year);
        
        $weeks = Week::where('year', $selectedYear)->orderBy('week_number', 'asc')->paginate(10);
        return view('week.index', compact('weeks', 'selectedYear', 'availableYears'));
    }

    public function create(): View
    {
        return view('week.create');
    }

    public function store(WeekRequest $request): RedirectResponse
    {

        $year = $request->input('year');
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

        return redirect()->route('week.index')->with('success', "Les semaines de l'année $year ont été générées.");
    }

    /**
    * Permet d'afficher la vue form qui permet d'ajouter les poney à une semaine. 
    */
    public function managePony(Week $week): View
    {
        $ponies = Pony::all();
        $assignedPonies = $week->ponies;
        return view('week.managePony', compact('week', 'ponies', 'assignedPonies'));
    }

    public function updatePony(Request $request, Week $week): RedirectResponse
    {
        $data = $request->input('ponies', []);
        $syncData = [];
        $errors = [];
    
        // Récupérer les heures déjà assignées pour chaque poney dans la semaine
        $assignedHours = $week->ponies()->withPivot('assigned_hours')->get()->pluck('pivot.assigned_hours', 'id');
        foreach ($data as $ponyId => $maxHours) {
            // Vérifier si le poney a des heures assignées
            $currentAssignedHours = $assignedHours->get($ponyId, 0);
            
            // Vérifier si le nouveau maximum est inférieur aux heures déjà assignées
            if ($maxHours < $currentAssignedHours) {
                $pony = Pony::find($ponyId);
                $errors[] = "Le nombre d'heures maximum pour le poney $pony->name ne peut pas être inférieur aux heures déjà assignées ($currentAssignedHours).";
                continue;
            }
    
            if ($maxHours > 0) {
                $syncData[$ponyId] = ['max_work_hours' => $maxHours];
            }
        }
    
        if (!empty($errors)) {
            return redirect()->route('appointment.index', ['week' => $week->id])
                ->withErrors($errors);
        }
    
        $week->ponies()->sync($syncData);
    
        return redirect()->route('appointment.index', ['week' => $week->id]);
    }
}
