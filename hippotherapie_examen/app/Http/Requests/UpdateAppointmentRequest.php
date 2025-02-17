<?php

namespace App\Http\Requests;

use App\Models\PonyWeek;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_date' => 'required|date',
            'start_hour' => 'required|date_format:H:i',
            'end_hour' => 'required|date_format:H:i|after:start_hour',
            'ponies' => 'required|array',
            'ponies.*' => 'exists:ponies,id',
            'price' => 'required|numeric',
            'number_of_people' => 'required|integer|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errors = [];
            $week = $this->route('week'); 
            $appointment = $this->route('appointment'); 
            if ($appointment->billed) {
                return redirect()->back()->withErrors(['message' => 'Ce rendez-vous a déjà été facturé et ne peut pas être modifié.']);
            }

            $startTime = Carbon::createFromTimeString($this->start_hour);
            $endTime = Carbon::createFromTimeString($this->end_hour);
            $duration = $startTime->diffInHours($endTime);

            $oldStartTime = Carbon::createFromTimeString($appointment->start_hour);
            $oldEndTime = Carbon::createFromTimeString($appointment->end_hour);
            $oldDuration = $oldStartTime->diffInHours($oldEndTime);

            foreach ($this->ponies as $ponyId) {
                $ponyWeek = PonyWeek::where('pony_id', $ponyId)
                    ->where('week_id', $week->id)
                    ->first();

                if (!$ponyWeek) {
                    $errors[] = "Le poney sélectionné n'est pas assigné à cette semaine.";
                    continue;
                }

                $assignedHours = $ponyWeek->assigned_hours;

                // Calculer les heures utilisées pour ce poney, en excluant le rdv en cours de mise à jour
                $usedHours = $week->appointments()
                    ->where('id', '!=', $appointment->id)
                    ->whereHas('ponies', function ($query) use ($ponyId) {
                        $query->where('ponies.id', $ponyId);
                    })
                    ->get()
                    ->sum(function ($appt) {
                        $start = Carbon::parse($appt->start_hour);
                        $end = Carbon::parse($appt->end_hour);
                        return $start->diffInHours($end);
                    });

                $adjustedUsedHours = $usedHours + $duration - $oldDuration;

                if ($adjustedUsedHours > $ponyWeek->max_work_hours) {
                    $errors[] = "Le poney {$ponyWeek->pony->name} a déjà presté trop d'heures cette semaine. Il lui reste " . ($ponyWeek->max_work_hours - $assignedHours) . " heures.";
                }

                // Vérifier les chevauchements d'horaires
                $overlappingAppointments = $week->appointments()
                    ->where('appointment_date', $this->appointment_date)
                    ->where('id', '!=', $appointment->id) // Exclure l'appointment en cours de mise à jour
                    ->whereHas('ponies', function ($query) use ($ponyId) {
                        $query->where('ponies.id', $ponyId);
                    })
                    ->get()
                    ->filter(function ($appt) use ($startTime, $endTime) {
                        $apptStart = Carbon::parse($appt->start_hour);
                        $apptEnd = Carbon::parse($appt->end_hour);
                        return $startTime->lt($apptEnd) && $endTime->gt($apptStart);
                    });

                if ($overlappingAppointments->isNotEmpty()) {
                    $errors[] = "Le poney {$ponyWeek->pony->name} a un conflit d'horaires pour le rendez-vous du {$this->appointment_date} avec les heures {$startTime->format('H:i')} - {$endTime->format('H:i')}.";
                }
            }

            if (!empty($errors)) {
                $validator->errors()->add('ponies', $errors);
            }
        });
    }
               
}
