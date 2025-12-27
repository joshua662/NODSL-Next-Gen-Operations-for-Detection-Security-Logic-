<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Residents Management</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Manage resident profiles and information</p>
        </div>
        <flux:button wire:click="openCreateModal" variant="primary">Add New Resident</flux:button>
    </div>

    @if (session()->has('message'))
        <div class="rounded-lg bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800 px-4 py-3 text-sm text-green-800 dark:text-green-200">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-4">
        <flux:input wire:model.live="search" placeholder="Search by name, plate number, or contact..." />
        
        <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
            <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Plate Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Car Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($residents as $resident)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $resident->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $resident->plate_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">{{ $resident->contact_number }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ \Illuminate\Support\Str::limit($resident->address, 30) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                @if($resident->car_model || $resident->car_color)
                                    {{ $resident->car_model ?? 'N/A' }} - {{ $resident->car_color ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex gap-2">
                                    <flux:button wire:click="openEditModal({{ $resident->id }})" variant="ghost" size="sm">Edit</flux:button>
                                    <flux:button wire:click="delete({{ $resident->id }})" wire:confirm="Are you sure you want to delete this resident?" variant="ghost" size="sm" class="text-red-600">Delete</flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-zinc-500">No residents found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $residents->links() }}
        </div>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-zinc-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-zinc-100 mb-4" id="modal-title">
                            {{ $editingResident ? 'Edit Resident' : 'Add New Resident' }}
                        </h3>
                        <form wire:submit="save" class="space-y-4">
                            <flux:input wire:model="name" label="Name" required />
                            <flux:input wire:model="email" type="email" label="Email" required />
                            @if(!$editingResident)
                                <flux:input wire:model="password" type="password" label="Password" required />
                            @else
                                <flux:input wire:model="password" type="password" label="Password (leave blank to keep current)" />
                            @endif
                            <flux:input wire:model="contact_number" label="Contact Number" required />
                            <flux:input wire:model="plate_number" label="Plate Number" required />
                            <flux:input wire:model="age" type="number" label="Age" />
                            <flux:textarea wire:model="address" label="Address" required />
                            <flux:input wire:model="car_model" label="Car Model" />
                            <flux:input wire:model="car_color" label="Car Color" />
                            <div class="flex justify-end gap-3 mt-6">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">Cancel</flux:button>
                                <flux:button type="submit" variant="primary">Save</flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
