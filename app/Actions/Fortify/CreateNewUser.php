<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $role = $input['role'] ?? 'resident';
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['nullable', 'in:admin,resident'],
        ];

        // For residents, require phone, plate_number, and address
        if ($role === 'resident') {
            $rules['phone'] = ['required', 'string', 'max:20'];
            $rules['plate_number'] = ['required', 'string', 'max:20', 'unique:residents,plate_number'];
            $rules['address'] = ['required', 'string'];
        } else {
            // For admin, phone and plate_number are optional
            $rules['phone'] = ['nullable', 'string', 'max:20'];
            $rules['plate_number'] = ['nullable', 'string', 'max:20'];
        }

        Validator::make($input, $rules)->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => $role,
            'phone' => $input['phone'] ?? null,
            'plate_number' => $input['plate_number'] ?? null,
        ]);

        // Only create resident profile if role is resident
        if ($role === 'resident') {
            \App\Models\Resident::create([
                'user_id' => $user->id,
                'name' => $input['name'],
                'plate_number' => $input['plate_number'],
                'contact_number' => $input['phone'],
                'address' => $input['address'] ?? '',
            ]);
        }

        return $user;
    }
}
