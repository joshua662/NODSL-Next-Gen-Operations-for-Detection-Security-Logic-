<?php

namespace App\Livewire\Admin;

use App\Models\Resident;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ResidentsManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingResident = null;
    public $name = '';
    public $age = '';
    public $address = '';
    public $plate_number = '';
    public $car_model = '';
    public $car_color = '';
    public $contact_number = '';
    public $email = '';
    public $password = '';

    public function mount()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }

    public function search()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editingResident = null;
        $this->showModal = true;
    }

    public function openEditModal($residentId)
    {
        $resident = Resident::with('user')->findOrFail($residentId);
        $this->editingResident = $resident;
        $this->name = $resident->name;
        $this->age = $resident->age ?? '';
        $this->address = $resident->address;
        $this->plate_number = $resident->plate_number;
        $this->car_model = $resident->car_model ?? '';
        $this->car_color = $resident->car_color ?? '';
        $this->contact_number = $resident->contact_number;
        $this->email = $resident->user->email;
        $this->password = '';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->age = '';
        $this->address = '';
        $this->plate_number = '';
        $this->car_model = '';
        $this->car_color = '';
        $this->contact_number = '';
        $this->email = '';
        $this->password = '';
        $this->resetErrorBag();
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1|max:150',
            'address' => 'required|string',
            'plate_number' => 'required|string|max:20|unique:residents,plate_number' . ($this->editingResident ? ',' . $this->editingResident->id : ''),
            'car_model' => 'nullable|string|max:255',
            'car_color' => 'nullable|string|max:100',
            'contact_number' => 'required|string|max:20',
        ];

        if ($this->editingResident) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->editingResident->user_id;
            if ($this->password) {
                $rules['password'] = 'min:8';
            }
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:8';
        }

        $this->validate($rules);

        if ($this->editingResident) {
            // Update existing resident
            $this->editingResident->update([
                'name' => $this->name,
                'age' => $this->age ?: null,
                'address' => $this->address,
                'plate_number' => $this->plate_number,
                'car_model' => $this->car_model ?: null,
                'car_color' => $this->car_color ?: null,
                'contact_number' => $this->contact_number,
            ]);

            $user = $this->editingResident->user;
            $user->email = $this->email;
            $user->phone = $this->contact_number;
            $user->plate_number = $this->plate_number;
            if ($this->password) {
                $user->password = Hash::make($this->password);
            }
            $user->save();

            session()->flash('message', 'Resident updated successfully.');
        } else {
            // Create new resident
            $user = \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'resident',
                'phone' => $this->contact_number,
                'plate_number' => $this->plate_number,
            ]);

            Resident::create([
                'user_id' => $user->id,
                'name' => $this->name,
                'age' => $this->age ?: null,
                'address' => $this->address,
                'plate_number' => $this->plate_number,
                'car_model' => $this->car_model ?: null,
                'car_color' => $this->car_color ?: null,
                'contact_number' => $this->contact_number,
            ]);

            session()->flash('message', 'Resident created successfully.');
        }

        $this->closeModal();
    }

    public function delete($residentId)
    {
        $resident = Resident::findOrFail($residentId);
        $resident->user->delete(); // This will cascade delete the resident
        session()->flash('message', 'Resident deleted successfully.');
    }

    public function render()
    {
        $query = Resident::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('plate_number', 'like', '%' . $this->search . '%')
                  ->orWhere('contact_number', 'like', '%' . $this->search . '%');
            });
        }

        $residents = $query->with('user')->paginate(15);

        return view('livewire.admin.residents-management', [
            'residents' => $residents,
        ]);
    }
}
