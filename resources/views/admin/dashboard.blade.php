    @props(['title' => 'Dashboard Admin Artikel Gizila'])

    <x-layouts.admin :title="$title">
        <div class="relative">
        
        </div>

        <div class="flex items-center gap-4 mb-8 border-b border-green-500 pb-6 animate-fade-in">
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover shadow-lg ring-2 ring-green-500">
            @else
                <div class="w-20 h-20 rounded-full bg-green-200 flex items-center justify-center text-2xl font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            <div>
                <h2 class="text-2xl font-semibold text-gizila-dark dark:text-white">
                    <span id="greeting"></span>, {{ $user->name }} 👋
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">Selamat datang kembali di Dashboard admin Gizila.</p>
            </div>
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 animate-fade-in">Waktu sekarang: <span id="current-time"></span></p>

        <div class="space-y-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-gizila-dark dark:text-white mb-4 border-l-4 border-green-500 pl-4">{{ $title }}</h1>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-green-100 to-white dark:from-gray-800 dark:to-gray-900 border border-green-300 dark:border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Total Artikel</h2>
                    <p class="text-6xl font-extrabold text-green-600 dark:text-green-400">{{ $totalArticles }}</p>
                    <a href="{{ route('admin.blog.index') }}" class="mt-4 inline-block text-gray-800 dark:text-blue-400 hover:underline text-sm">
                        ➜ Lihat semua artikel
                    </a>
                </div>

                <div class="bg-gradient-to-br from-green-100 to-white dark:from-gray-800 dark:to-gray-900 border border-green-300 dark:border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Statistik Artikel Bulanan</h2>
                    <canvas id="articleChart" class="w-full h-60"></canvas>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-100 to-white dark:from-gray-800 dark:to-gray-900 border border-green-300 dark:border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-xl transition">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Statistik Akses Artikel oleh User</h2>
        <canvas id="userAccessChart" class="w-full h-60"></canvas>
    </div>


            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-lg transition">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Artikel Terbaru</h2>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($articles as $article)
                        <li class="py-2">
                            <a href="{{ route('admin.blog.edit', $article->id) }}" class="font-medium text-green-700 dark:text-green-400 hover:underline">
                                {{ $article->title }}
                            </a>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $article->created_at->format('d M Y') }}</div>
                        </li>
                    @empty
                        <li class="text-gray-500 dark:text-gray-400 text-sm">Belum ada artikel.</li>
                    @endforelse
                </ul>
            </div>
        </div>

       <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Grafik Akses User
    fetch('{{ route('admin.userAksesGrafik') }}')
        .then(res => res.json())
        .then(userData => {
            const ctx = document.getElementById('userAccessChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [...Array(12).keys()].map(i => new Date(0, i).toLocaleString('default', { month: 'long' })),
                    datasets: [{
                        label: 'User Mengakses Artikel (per bulan)',
                        data: userData,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true }
                    }
                }
            });
        });

    // 2. Grafik Artikel Dibuat
    fetch('{{ route('admin.articleCreatedGrafik') }}')
        .then(res => res.json())
        .then(dataCreated => {
            const ctx = document.createElement('canvas');
            ctx.id = 'createdChart';
            document.getElementById('articleChart').parentNode.appendChild(ctx);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [...Array(12).keys()].map(i => new Date(0, i).toLocaleString('default', { month: 'long' })),
                    datasets: [{
                        label: 'Artikel Dibuat',
                        data: dataCreated,
                        borderColor: 'rgba(34,197,94,1)',
                        backgroundColor: 'rgba(34,197,94,0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { plugins: { legend: { display: true } }, responsive: true }
            });
        });

    // 3. Artikel Published
    fetch('{{ route('admin.articlePublishedGrafik') }}')
        .then(res => res.json())
        .then(dataPublished => {
            const ctx = document.createElement('canvas');
            ctx.id = 'publishedChart';
            document.getElementById('articleChart').parentNode.appendChild(ctx);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [...Array(12).keys()].map(i => new Date(0, i).toLocaleString('default', { month: 'long' })),
                    datasets: [{
                        label: 'Artikel Dipublish',
                        data: dataPublished,
                        borderColor: 'rgba(59,130,246,1)',
                        backgroundColor: 'rgba(59,130,246,0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { plugins: { legend: { display: true } }, responsive: true }
            });
        });

    // 4. Artikel Draft
    fetch('{{ route('admin.articleDraftGrafik') }}')
        .then(res => res.json())
        .then(dataDraft => {
            const ctx = document.createElement('canvas');
            ctx.id = 'draftChart';
            document.getElementById('articleChart').parentNode.appendChild(ctx);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [...Array(12).keys()].map(i => new Date(0, i).toLocaleString('default', { month: 'long' })),
                    datasets: [{
                        label: 'Artikel Draft',
                        data: dataDraft,
                        borderColor: 'rgba(251,191,36,1)',
                        backgroundColor: 'rgba(251,191,36,0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { plugins: { legend: { display: true } }, responsive: true }
            });
        });
</script>



        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const articleData = @json($articlePerMonth);
            const labels = articleData.map(d => new Date(0, d.month - 1).toLocaleString('default', { month: 'long' }));
            const data = articleData.map(d => d.total);
            const ctx = document.getElementById('articleChart').getContext('2d');
            const articleChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Artikel per Bulan',
                        data: data,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(5, 150, 105, 1)',
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } }
                }
            });

            // setInterval(() => location.reload(), 30000);

            const now = new Date();
            const hour = now.getHours();
            let greeting = "Hello";
            if (hour >= 5 && hour < 12) greeting = "Good Morning";
            else if (hour >= 12 && hour < 17) greeting = "Good Afternoon";
            else if (hour >= 17 && hour < 21) greeting = "Good Evening";
            else greeting = "Good Night";
            document.getElementById("greeting").textContent = greeting;

            document.getElementById("current-time").textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            function toggleDarkMode() {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            }

            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        </script>

        <style>
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fade-in 0.6s ease-out;
            }
        </style>
    </x-layouts.admin>
