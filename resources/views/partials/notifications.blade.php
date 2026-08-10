<div class="relative group/notif inline-block text-left" x-data="{ open: false }">
    <button type="button" @click="open = !open" @click.away="open = false" class="relative p-2 text-slate-500 hover:text-indigo-600 transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        @if($deadline_notifications->count() > 0)
            <span class="absolute top-1.5 right-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                {{ $deadline_notifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" x-cloak style="display: none;" 
         class="fixed inset-x-4 top-16 sm:absolute sm:inset-auto sm:right-0 z-50 sm:mt-2 sm:w-80 origin-top sm:origin-top-right rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-slate-800">Notifikasi Deadline</h3>
            @if($deadline_notifications->count() > 0)
                <span class="px-2 py-0.5 text-[10px] font-bold bg-red-100 text-red-700 rounded-full">{{ $deadline_notifications->count() }} Baru</span>
            @endif
        </div>
        <div class="max-h-80 overflow-y-auto">
            @forelse($deadline_notifications as $notif)
                @php
                    $diffDays = \Carbon\Carbon::parse($notif->target_selesai)->diffInDays(now(), false);
                    $isOverdue = $diffDays > 0;
                @endphp
                <a href="{{ route('projects.show', $notif->id) }}" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-50 transition-colors">
                    <p class="text-sm font-bold text-slate-800">{{ $notif->nama_project }}</p>
                    <p class="text-xs {{ $isOverdue ? 'text-red-600 font-bold' : 'text-amber-600' }} mt-1">
                        {{ $isOverdue ? 'Telah lewat deadline!' : 'Deadline ' . abs(ceil($diffDays)) . ' hari lagi' }} 
                        ({{ \Carbon\Carbon::parse($notif->target_selesai)->format('d M Y') }})
                    </p>
                </a>
            @empty
                <div class="px-4 py-8 text-center text-slate-500">
                    <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-medium">Yeay! Tidak ada deadline yang mendesak.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>


