<?php

namespace App\Http\Requests;

use App\Models\PonyWeek;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
        $week=$this->route('week');
        return [
            'appointment_date' => 'required|date|after_or_equal:' . $week->start_date . '|before_or_equal:' . $week->end_date,
            'start_hour' => 'required|date_format:H:i',
            'end_hour' => 'required|date_format:H:i|after:start_hour',
            'ponies' => 'required|array|min:1',
            'ponies.*' => 'exists:ponies,id',
            'price' => 'required|min:1',
            'customer_id' => 'required|exists:customers,id',
            'number_of_people' => 'required|integer|min:1',
        ];
    }

    public function messages()
{
        return [
            'appointment_date.required' => 'La date du rendez-vous est obligatoire.',
            'appointment_date.date' => 'La date du rendez-vous doit être une date valide.',
            'appointment_date.after_or_equal' => 'La date du rendez-vous doit être après ou égale au début de la semaine : ' . $this->week->start_date . '.',
            'appointment_date.before_or_equal' => 'La date du rendez-vous doit être avant ou égale à la fin de la semaine : ' . $this->week->end_date . '.',
            
            'start_hour.required' => "L'heure de début est obligatoire.",
            'start_hour.date_format' => "L'heure de début doit respecter le format HH:mm.",
            
            'end_hour.required' => "L'heure de fin est obligatoire.",
            'end_hour.date_format' => "L'heure de fin doit respecter le format HH:mm.",
            'end_hour.after' => "L'heure de fin doit être après l'heure de début.",
            
            'ponies.required' => 'Vous devez sélectionner au moins un poney.',
            'ponies.array' => 'Les poneys doivent être envoyés sous forme de tableau.',
            'ponies.min' => 'Vous devez sélectionner au moins un poney.',
            'ponies.*.exists' => "Un ou plusieurs poneys sélectionnés n'existent pas dans la base de données.",
            
            'price.required' => 'Le prix est obligatoire.',
            'price.min' => 'Le prix doit être au minimum de 1 €.',
            
            'customer_id.required' => 'Le client est obligatoire.',
            'customer_id.exists' => "Le client sélectionné n'existe pas dans la base de données.",
            
            'number_of_people.required' => 'Le nombre de personnes est obligatoire.',
            'number_of_people.integer' => 'Le nombre de personnes doit être un entier.',
            'number_of_people.min' => 'Le nombre de personnes doit être au moins égal à 1.',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errors = [];
            $week = $this->route('week'); 

            $startTime = Carbon::createFromTimeString($this->start_hour);
            $endTime = Carbon::createFromTimeString($this->end_hour);
            $duration = $startTime->diffInHours($endTime);

            foreach ($this->ponies as $ponyId) {
                $ponyWeek = PonyWeek::where('pony_id', $ponyId)
                    ->where('week_id', $week->id)
                    ->first();

                $assignedHours = $ponyWeek->assigned_hours;

                if ($assignedHours + $duration > $ponyWeek->max_work_hours) {
                    $errors[] = "Le poney {$ponyWeek->pony->name} a déjà presté trop d'heures cette semaine. Il lui reste " . ($ponyWeek->max_work_hours - $assignedHours) . " heures.";
                }

                // Vérifier les chevauchements d'horaires
                $overlappingAppointments = $week->appointments()
                    ->where('appointment_date', $this->appointment_date)
                    ->whereHas('ponies', function ($query) use ($ponyId) {
                        $query->where('ponies.id', $ponyId);
                    })
                    ->get()
                    ->filter(function ($appointment) use ($startTime, $endTime) {
                        $appointmentStart = Carbon::parse($appointment->start_hour);
                        $appointmentEnd = Carbon::parse($appointment->end_hour);

                        // Vérifier si les heures se chevauchent
                        return $startTime->lt($appointmentEnd) && $endTime->gt($appointmentStart);
                    });

                if ($overlappingAppointments->isNotEmpty()) {
                    $formated_date = Carbon::parse($this->appointment_date)->format('d-m-Y');
                    $errors[] = "Le poney {$ponyWeek->pony->name} a un conflit d'horaires pour le rendez-vous du {$formated_date} avec les heures {$startTime->format('H:i')} - {$endTime->format('H:i')}.";
                }
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $validator->errors()->add('ponies', $error);
                }
            }
        });
    }
}
