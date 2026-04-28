<x-app-layout>
    <div class="py-12 bg-[#0a0f1d] min-h-screen text-white font-sans">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-[#facc15] via-[#a16207] to-[#0a0f1d] rounded-[3rem] p-8 flex items-center justify-between shadow-2xl border border-white/5">
                <div class="flex items-center gap-6">
                    <div class="bg-white rounded-2xl p-2 w-24 h-24 shadow-lg overflow-hidden">
                        <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                    </div>
                    <div class="space-y-1">
                        @if($isVerified)
                            <span class="bg-black/40 text-[10px] px-3 py-0.5 rounded-full uppercase font-black tracking-tighter border border-white/10">Verified User</span>
                        @endif
                        <h1 class="text-6xl font-bold tracking-tighter">{{ $userName }}</h1>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold opacity-80 italic">Account age : {{ $accountAge }} years</p>
                    <p class="text-2xl font-bold mt-2 italic">Status : {{ $userStatus }}</p>
                </div>
            </div>

            <div class="bg-[#111827] rounded-[2.5rem] p-10 flex items-center gap-12 border border-white/5 shadow-xl">
                <div class="w-64 h-64 relative">
                    <canvas id="genreChart"></canvas>
                </div>

                <div class="flex-1 space-y-4">
                    <h3 class="text-2xl font-bold text-gray-400 uppercase tracking-widest mb-4">Top Genres</h3>
                    @foreach($genres as $index => $genre)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ ['#facc15', '#a16207', '#0369a1', '#1e293b'][$index] ?? '#444' }}"></div>
                            <span class="text-lg font-semibold text-gray-300">{{ $genre['genre'] }}</span>
                        </div>
                        <span class="text-lg font-bold text-sky-400">{{ $genre['percentage'] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-[#111827] rounded-3xl p-8 border border-white/5 text-center group hover:bg-[#161e2e] transition-all">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2 tracking-widest">Listening time (30 days)</p>
                    <p class="text-3xl font-bold text-white">{{ round($listeningTime30Days)  }}min</p>
                </div>
                <div class="bg-[#111827] rounded-3xl p-8 border border-white/5 text-center group hover:bg-[#161e2e] transition-all">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2 tracking-widest">Listening time (year)</p>
                    <p class="text-3xl font-bold text-white">{{ round($listeningTimeYear) }}min</p>
                </div>

                <div class="bg-[#111827] rounded-3xl p-8 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2 tracking-widest">Library Size</p>
                    <p class="text-3xl font-bold text-white">{{ $librarySize }} songs</p>
                    <p class="text-[10px] text-gray-600 mt-1 italic">(in {{ $playlistCount }} playlists)</p>
                </div>
                <div class="bg-[#111827] rounded-3xl p-8 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2 tracking-widest">Playlist</p>
                    <p class="text-3xl font-bold text-white">{{ $playlistCount }}</p>
                </div>

                <div class="bg-[#111827] rounded-3xl p-8 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2 tracking-widest">Top Artist</p>
                    @foreach($topArtists as $artist)
                        <p class="text-2xl font-bold text-yellow-500 tracking-tight">{{ $artist['artist_name'] }}</p>
                    @endforeach
                </div>
                <div class="bg-[#111827] rounded-3xl p-8 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2 tracking-widest">Subscription</p>
                   {{-- <p class="text-2xl font-bold {{ $subscription === 'premium' ? 'text-yellow-400' : 'text-gray-400' }}">
                        {{ strtoupper($subscription) }}--}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('genreChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(collect($genres)->pluck('genre')) !!},
                datasets: [{
                    data: {!! json_encode(collect($genres)->pluck('percentage')) !!},
                    backgroundColor: ['#facc15', '#a16207', '#0369a1', '#1e293b'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                cutout: '50%',
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-app-layout>
