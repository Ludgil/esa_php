<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pony;
use App\Models\Week;
use App\Models\Appointment;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer l'année et le mois depuis la requête, avec des valeurs par défaut
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        // Récupérer les années distinctes à partir des semaines existantes
        $years = Week::selectRaw('DISTINCT strftime("%Y", start_date) as year')->pluck('year');
        // Récupérer les semaines qui correspondent au mois et à l'année
        $weeks = Week::whereYear('start_date', $year)
            ->whereMonth('start_date', $month)
            ->get();

        // Récupérer les IDs des semaines
        $weekIds = $weeks->pluck('id');

        // Récupérer les rendez-vous associés à ces semaines
        $appointments = Appointment::with('ponies')
            ->whereIn('week_id', $weekIds) // Assurez-vous que votre modèle Appointment a une relation avec Week
            ->get();

        // Initialiser un tableau pour stocker les heures par poney
        $hoursByPony = [];

        // Calculer la somme des heures pour chaque poney
        foreach ($appointments as $appointment) {
            $startTime = Carbon::parse($appointment->start_hour);
            $endTime = Carbon::parse($appointment->end_hour);
            $duration = $startTime->diffInHours($endTime);

            foreach ($appointment->ponies as $pony) {
                if (!isset($hoursByPony[$pony->id])) {
                    $hoursByPony[$pony->id] = 0; // Initialiser si pas encore défini
                }
                $hoursByPony[$pony->id] += $duration; // Ajouter la durée
            }
        }

        // Récupérer les noms des poneys
        $ponies = Pony::whereIn('id', array_keys($hoursByPony))->get()->keyBy('id');

        // Préparer les données pour le graphique
        $graphData = [];
        $poniesNames = [];

        foreach ($hoursByPony as $ponyId => $totalHours) {
            $graphData[$ponyId] = $totalHours;
            $poniesNames[$ponyId] = $ponies[$ponyId]->name;
        }
        return view('main.index', compact('graphData', 'poniesNames', 'year', 'month', 'years'));
    }
}
