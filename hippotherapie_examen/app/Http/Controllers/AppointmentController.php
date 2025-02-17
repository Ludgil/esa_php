<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Carbon\Carbon;
use App\Models\Pony;
use App\Models\Week;
use App\Models\PonyWeek;
use Illuminate\View\View;
use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    public function index(Week $week): View
    {
        $appointments = $week->appointments()->with('customer')->orderBy('appointment_date', 'asc')->get();
        // Récupérer les poneys avec les heures maximales et assignées
        $ponies = $week->ponies()->withPivot('max_work_hours', 'assigned_hours')->get()->map(function ($pony) {
            // Calculer le temps restant
            $remainingHours = $pony->pivot->max_work_hours - $pony->pivot->assigned_hours;
            $pony->remaining_hours = $remainingHours;
            return $pony;
        });
        return view('appointment.index', compact('week', 'appointments', 'ponies'));
    }


    public function store(AppointmentRequest $request, Week $week): RedirectResponse
    {
        $appointment = Appointment::create([
            'week_id' => $week->id,
            'appointment_date' => $request->appointment_date,
            'start_hour' => $request->start_hour,
            'end_hour' => $request->end_hour,
            'price' => $request->price,
            'customer_id' => $request->customer_id,
            'number_of_people' => $request->number_of_people, 
        ]);

        // Association des poneys et mise à jour des heures assignées
        if ($request->has('ponies')) {
            $appointment->ponies()->sync($request->ponies);

            // Calculer la durée d'un rendez-vous
            $startTime = Carbon::createFromTimeString($request->start_hour);
            $endTime = Carbon::createFromTimeString($request->end_hour);
            $duration = $startTime->diffInHours($endTime);

            // Mettre à jour les heures assignées pour chaque poney
            foreach ($request->ponies as $ponyId) {
                $ponyWeek = PonyWeek::where('pony_id', $ponyId)
                    ->where('week_id', $week->id)
                    ->first();

                // Mettre à jour les heures assignées
                $ponyWeek->assigned_hours += $duration; // Ajouter la durée du rendez-vous
                $ponyWeek->save();
            }
        }

        return redirect()->route('appointment.index', $week->id);
    }



    public function create(Week $week): View
    {
        $ponies = $week->ponies;
        $customers = Customer::all();
        return view('appointment.create', compact('week', 'ponies', 'customers'));
    }

    public function edit(Week $week, Appointment $appointment): View
    {
        $customers = Customer::all();
        return view('appointment.edit', compact('week', 'appointment', 'customers'));
    }

    public function update(UpdateAppointmentRequest $request, Week $week, Appointment $appointment)
    {
        $startTime = Carbon::createFromTimeString($request->start_hour);
        $endTime = Carbon::createFromTimeString($request->end_hour);
        $duration = $startTime->diffInHours($endTime);

        // Récupérer la durée de l'ancien rendez-vous
        $oldStartTime = Carbon::createFromTimeString($appointment->start_hour);
        $oldEndTime = Carbon::createFromTimeString($appointment->end_hour);
        $oldDuration = $oldStartTime->diffInHours($oldEndTime);

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'start_hour' => $request->start_hour,
            'end_hour' => $request->end_hour,
            'price' => $request->price,
            'number_of_people' => $request->number_of_people,
        ]);

        // Mise à jour des heures assignées pour les poneys
        foreach ($request->ponies as $ponyId) {
            $ponyWeek = PonyWeek::where('pony_id', $ponyId)
                ->where('week_id', $week->id)
                ->first();

            if ($ponyWeek) {
                // Si le poney était déjà associé, ajuster les heures assignées
                if ($appointment->ponies()->where('ponies.id', $ponyId)->exists()) {
                    // Ajuster les heures assignées en soustrayant l'ancienne durée et en ajoutant la nouvelle
                    $newAssignedHours = $ponyWeek->assigned_hours + $duration - $oldDuration;

                    // Vérifier si cela dépasse le maximum autorisé
                    if ($newAssignedHours > $ponyWeek->max_work_hours) {
                        return redirect()->back()->withErrors(['ponies' => ["Le poney {$ponyWeek->pony->name} a déjà presté trop d'heures cette semaine."]])->withInput();
                    }

                    $ponyWeek->assigned_hours = $newAssignedHours; 
                } else {
                    // Si le poney est nouveau, vérifier d'abord avant d'ajouter la durée
                    $newAssignedHours = $ponyWeek->assigned_hours + $duration;

                    // Vérifier si cela dépasse le maximum autorisé
                    if ($newAssignedHours > $ponyWeek->max_work_hours) {
                        return redirect()->back()->withErrors(['ponies' => ["Le poney {$ponyWeek->pony->name} a déjà presté trop d'heures cette semaine."]])->withInput();
                    }

                    $ponyWeek->assigned_hours = $newAssignedHours;
                }
                $ponyWeek->save();
            }
        }

        // Retirer les poneys qui ne sont plus associés au rendez-vous
        $removedPonies = $appointment->ponies()->whereNotIn('ponies.id', $request->ponies)->get();
        foreach ($removedPonies as $removedPony) {
            $ponyWeek = PonyWeek::where('pony_id', $removedPony->id)
                ->where('week_id', $week->id)
                ->first();

            if ($ponyWeek) {
                // mise à jour de la durée pour le poney retiré 
                $ponyWeek->assigned_hours -= $oldDuration;
                $ponyWeek->save();
            }
        }

        $appointment->ponies()->sync($request->ponies);

        return redirect()->route('appointment.index', $week->id);
    }

    public function destroy(Week $week, Appointment $appointment): RedirectResponse
    {
        if ($appointment->billed) {
            return redirect()->back()->withErrors(['message' => 'Ce rendez-vous a déjà été facturé et ne peut pas être supprimé.']);
        }

        $startTime = Carbon::createFromTimeString($appointment->start_hour);
        $endTime = Carbon::createFromTimeString($appointment->end_hour);
        $duration = $startTime->diffInHours($endTime);

        $ponies = $appointment->ponies;

        // Mettre à jour les heures assignées pour chaque poney
        foreach ($ponies as $pony) {
            $ponyWeek = PonyWeek::where('pony_id', $pony->id)
                ->where('week_id', $week->id)
                ->first();

            if ($ponyWeek) {
                $ponyWeek->assigned_hours -= $duration;
                $ponyWeek->save();
            }
        }
        $appointment->delete();
        return redirect()->route('appointment.index', $week->id);
    }

}
