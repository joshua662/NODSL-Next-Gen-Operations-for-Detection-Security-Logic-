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
                                    <flux:button wire:click="openDeleteModal({{ $resident->id }})" variant="ghost" size="sm" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</flux:button>
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

    <!-- Edit/Create Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>
                <div class="relative inline-block align-middle bg-white dark:bg-zinc-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
                    <div class="px-8 pt-8 pb-6">
                        <!-- Header with Icon -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    @if($editingResident)
                                        <svg class="w-10 h-10 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    @else
                                        <svg class="w-10 h-10 text-green-600 dark:text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    @endif
                                </div>
                                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100" id="modal-title">
                                    {{ $editingResident ? 'Edit Resident' : 'Add New Resident' }}
                                </h3>
                            </div>
                            <button wire:click="closeModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Form -->
                        <form wire:submit="save" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <flux:input wire:model="name" label="Name" required />
                                <flux:input wire:model="email" type="email" label="Email" required />
                            </div>
                            
                            @if(!$editingResident)
                                <flux:input wire:model="password" type="password" label="Password" required />
                            @else
                                <flux:input wire:model="password" type="password" label="Password (leave blank to keep current)" />
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <flux:input wire:model="contact_number" label="Contact Number" required />
                                <flux:input wire:model="plate_number" label="Plate Number" required />
                            </div>
                            
                            <flux:input wire:model="age" type="number" label="Age" />
                            <flux:textarea wire:model="address" label="Address" required />
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <flux:input wire:model="car_model" label="Car Model" />
                                <flux:input wire:model="car_color" label="Car Color" />
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                                <button 
                                    type="button" 
                                    wire:click="closeModal" 
                                    class="px-6 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors shadow-sm hover:shadow-md">
                                    {{ $editingResident ? 'Update Resident' : 'Create Resident' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal && $deletingResident)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="delete-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm transition-opacity" wire:click="closeDeleteModal"></div>
                <div class="relative inline-block align-middle bg-white dark:bg-zinc-800 rounded-2xl text-center overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md sm:w-full">
                    <div class="px-8 pt-10 pb-8">
                        <!-- Trash Icon -->
                        <div class="flex justify-center mb-6">
                            <svg class="w-16 h-16 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        
                        <!-- Question Text -->
                        <h3 class="text-xl font-medium text-zinc-900 dark:text-zinc-100 mb-8" id="delete-modal-title">
                            Are you sure you want to delete <strong>{{ $deletingResident->name }}</strong>?
                        </h3>
                        
                        <!-- Action Button -->
                        <div class="space-y-4">
                            <button 
                                wire:click="delete" 
                                class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md">
                                Yes, Delete
                            </button>
                            
                            <!-- Cancel Link -->
                            <button 
                                wire:click="closeDeleteModal" 
                                class="block w-full text-sm text-zinc-900 dark:text-zinc-100 hover:text-zinc-600 dark:hover:text-zinc-300 font-medium transition-colors">
                                Keep Resident
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
