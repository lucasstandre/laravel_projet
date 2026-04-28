<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jvectormap-next@3.0.0/dist/jquery-jvectormap.css">

    <div class="py-12 bg-[#000d1a] min-h-screen text-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-gradient-to-r from-[#fcd34d] via-[#b45309] to-[#000d1a] rounded-[3rem] p-8 flex items-center justify-between shadow-2xl border border-white/10">
                <div class="flex items-center gap-6">
                    <div class="bg-white rounded-full p-4 w-24 h-24 flex items-center justify-center shadow-inner">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                    </div>
                    <div>
                        @if($isVerifiedArtist)
                            <span class="bg-black/40 text-xs px-3 py-1 rounded-full uppercase font-bold tracking-widest border border-white/20">Verified Artist</span>
                        @endif
                        <h1 class="text-6xl font-bold mt-2 leading-none tracking-tighter">{{ $artistName }}</h1>
                    </div>
                </div>
                <div class="text-right space-y-2">
                    <p class="text-xl font-bold italic opacity-90">Global Rank : {{ $globalRank }}</p>
                    <p class="text-xl font-bold italic opacity-90">Monthly Listener : {{ $monthlyListenersFormatted }}</p>
                    <p class="text-xl font-bold italic opacity-90">Top Country : {{ $topCountry }}</p>
                </div>
            </div>

            <div class="bg-[#001a33] rounded-[2.5rem] p-8 border border-white/5 shadow-lg">
                <h3 class="text-3xl font-bold mb-6 italic tracking-tight">Stream Trends</h3>
                <div class="h-64 relative">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $stats = [
                        ['label' => 'Total Stream', 'value' => $totalStreams],
                        ['label' => 'Active Listener', 'value' => $activeListeners],
                        ['label' => 'Follower Growth', 'value' => $followerGrowth],
                        ['label' => 'Playlist Add', 'value' => $playlistAdds]
                    ];
                @endphp
                @foreach($stats as $stat)
                    <div class="bg-[#001a33] p-6 rounded-2xl border border-white/5 text-center hover:border-yellow-500/50 transition-colors">
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-sky-400">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-[#001a33] rounded-[2.5rem] p-8 border border-white/5 shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl font-bold italic tracking-tight text-yellow-400">Audience Map</h3>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Live Regions</span>
                </div>
                <div id="world-map" class="rounded-2xl overflow-hidden" style="height: 400px; background: rgba(0,0,0,0.2);"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jvectormap-next@3.0.0/dist/jquery-jvectormap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jvectormap-next@3.0.0/lib/maps/world-mill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 1. Chart Trends
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($streamTrends['labels']) !!},
                datasets: [{
                    data: {!! json_encode($streamTrends['data']) !!},
                    borderColor: '#facc15',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: (context) => {
                        const gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(250, 204, 21, 0.2)');
                        gradient.addColorStop(1, 'rgba(250, 204, 21, 0)');
                        return gradient;
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { grid: { display: false }, ticks: { color: '#4b5563' } }
                }
            }
        });

        // 2. jVectorMap
        $(function(){
            $('#world-map').vectorMap({
                map: 'world_mill',
                backgroundColor: 'transparent',
                regionStyle: {
                    initial: { fill: '#1e293b', "fill-opacity": 1, stroke: 'none' },
                    hover: { "fill-opacity": 0.8, cursor: 'pointer', fill: '#334155' }
                },
                series: {
                    regions: [{
                        values: { 'CA': 100, 'US': 80, 'FR': 60, 'GB': 40 }, // A lier dynamiquement plus tard
                        scale: ['#1e293b', '#facc15'],
                        normalizeFunction: 'polynomial'
                    }]
                },
                markerStyle: {
                    initial: { fill: '#facc15', stroke: '#000', "stroke-width": 2, r: 6 }
                },
                markers: [
                    {latLng: [45.50, -73.56], name: 'Montreal (Top Listener)'},
                    {latLng: [48.85, 2.35], name: 'Paris'},
                    {latLng: [40.71, -74.00], name: 'New York'}
                ]
            });
        });
    </script>
</x-app-layout>
