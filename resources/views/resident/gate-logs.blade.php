<x-layouts.app :title="__('Gate Access Logs')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">📊 Gate Access Logs</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Your personal IN/OUT history and access records</p>
        </div>

        @php
            $logs = auth()->user()->resident->gateLogs()->latest('timestamp')->paginate(15);
        @endphp

        <!-- Summary Cards -->
        <div class="grid gap-4 md:grid-cols-3 mb-6">
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-zinc-50 dark:bg-zinc-900">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Total Entries Today</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->resident->gateLogs()->where('status', 'entry')->whereDate('timestamp', today())->count() }}</p>
            </div>
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-zinc-50 dark:bg-zinc-900">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Total Exits Today</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->resident->gateLogs()->where('status', 'exit')->whereDate('timestamp', today())->count() }}</p>
            </div>
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-zinc-50 dark:bg-zinc-900">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Unauthorized Attempts</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ auth()->user()->resident->gateLogs()->where('status', 'unauthorized')->count() }}</p>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-800">
            @if($logs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase">Access Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase">Plate Number</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase">Image</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($logs as $log)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                    <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">
                                        <div>
                                            <p class="font-medium">{{ $log->timestamp->format('M d, Y') }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $log->timestamp->format('H:i:s') }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($log->status === 'authorized')
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                <span class="text-green-700 dark:text-green-400 font-medium">AUTHORIZED</span>
                                            </div>
                                        @elseif($log->status === 'unauthorized')
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                <span class="text-red-700 dark:text-red-400 font-medium">UNAUTHORIZED</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                                <span class="text-yellow-700 dark:text-yellow-400 font-medium">{{ strtoupper($log->status) }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">
                                        @if($log->status === 'entry')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded">
                                                ⬇️ Entry
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium rounded">
                                                ⬆️ Exit
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono text-zinc-900 dark:text-zinc-100">
                                        {{ $log->plate_number ?? $log->resident->plate_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($log->image_path)
                                            <button onclick="openImageModal('{{ asset('storage/' . $log->image_path) }}')" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                                View
                                            </button>
                                        @else
                                            <span class="text-zinc-500 dark:text-zinc-400 text-sm">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-zinc-500 dark:text-zinc-400 text-lg">📭 No gate logs found</p>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-2">Your gate access history will appear here</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-zinc-800 rounded-xl max-w-2xl w-full p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Captured Plate Image</h3>
                <button onclick="closeImageModal()" class="text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200">
                    ✕
                </button>
            </div>
            <img id="modalImage" src="" alt="Captured plate" class="w-full rounded-lg">
        </div>
    </div>

    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-layouts.app>
