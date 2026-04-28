<x-app-layout>
    <div class="py-12 bg-[#0a0f1d] min-h-screen text-white font-sans">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-[#facc15] via-[#a16207] to-[#0a0f1d] rounded-[3rem] p-8 flex items-center justify-between border border-white/5">
                <div class="flex items-center gap-6">
                    <div class="bg-white rounded-full p-2 w-24 h-24 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                    </div>
                    <div>
                        @if($isVerifiedArtist)
                            <span class="bg-black/40 text-[10px] px-3 py-0.5 rounded-full uppercase font-black border border-white/10">Verified Artist</span>
                        @endif
                        <h1 class="text-6xl font-bold tracking-tighter">{{ $artistName }}</h1>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold opacity-80 italic">Rank : {{ $globalRank }}</p>
                    <p class="text-2xl font-bold mt-2 italic text-yellow-500">Top : {{ $topCountry }}</p>
                </div>
            </div>

            <div class="bg-[#111827] rounded-[2.5rem] p-10 border border-white/5">
                <h3 class="text-2xl font-bold text-gray-400 uppercase tracking-widest mb-6">Stream Trends</h3>
                <div class="h-64 relative">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#111827] rounded-3xl p-6 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2">Total Streams</p>
                    <p class="text-3xl font-bold">{{ $totalStreams }}</p>
                </div>
                <div class="bg-[#111827] rounded-3xl p-6 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2">Active Listeners</p>
                    <p class="text-3xl font-bold">{{ $activeListeners }}</p>
                </div>
                <div class="bg-[#111827] rounded-3xl p-6 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2">Growth</p>
                    <p class="text-3xl font-bold">{{ $followerGrowth }}</p>
                </div>
                <div class="bg-[#111827] rounded-3xl p-6 border border-white/5 text-center">
                    <p class="text-[10px] uppercase font-black text-gray-500 mb-2">Playlist Adds</p>
                    <p class="text-3xl font-bold">{{ $playlistAdds }}</p>
                </div>
            </div>

            <div class="bg-[#111827] rounded-[2.5rem] p-10 border border-white/5">
                <h3 class="text-2xl font-bold text-gray-400 uppercase tracking-widest mb-8 text-center">Audience Breakdown</h3>
                <div class="flex flex-col md:flex-row items-center justify-around gap-12">
                    <div class="w-64 h-64">
                        <canvas id="countryChart"></canvas>
                    </div>
                    <div class="flex-1 max-w-sm space-y-4">
                        @foreach($mapData  as $index => $data)
                        <div class="flex items-center justify-between border-b border-white/5 pb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ ['#facc15', '#a16207', '#0369a1', '#1e293b'][$index] ?? '#444' }}"></div>
                                <span class="text-lg font-semibold text-gray-300">{{ $data['name_country'] }}</span>
                            </div>
                            <span class="text-lg font-bold text-sky-400">{{ $data['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trends
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: [@foreach($trends as $t) "{{ $t['date'] }}", @endforeach],
                    datasets: [{
                        data: [@foreach($trends as $t) {{ $t['streams'] }}, @endforeach],
                        borderColor: '#facc15',
                        backgroundColor: 'rgba(250, 204, 21, 0.1)',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#666' } },
                        x: { grid: { display: false }, ticks: { color: '#666' } }
                    }
                }
            });

            // la pie chart des pays
            new Chart(document.getElementById('countryChart'), {
                type: 'doughnut',
                data: {
                    labels: [@foreach($mapData as $m) "{{ $m['name_country'] }}", @endforeach],
                    datasets: [{
                        data: [@foreach($mapData as $m) {{ $m['count'] }}, @endforeach],
                        backgroundColor: ['#facc15', '#a16207', '#0369a1', '#1e293b'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '60%',
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>
