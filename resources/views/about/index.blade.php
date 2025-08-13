<x-layout title="Tentang Gizila">
    <div class="bg-gizila-radial pt-28 pb-16 min-h-screen">
        <div class="container mx-auto px-4">
            {{-- Bagian Judul Halaman --}}
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    <span class="relative inline-block">
                        Tentang <span class="text-gizila-dark">Gizila</span>
                        <span class="absolute bottom-[-15px] left-0 h-1.5 w-full origin-left scale-x-0 transform bg-gizila-dark transition-transform duration-500 ease-in-out animate-draw-line"></span>
                    </span>
                </h1>
                <p class="text-gray-600 text-lg mt-10 text-justify">
                    Gizila merupakan sebuah media informasi yang masih tahap berkembang dibawah naungan PT. Graisena Usaha Nusantara (GUNTARA) yang bergerak dibidang creative agency. Gizila memberikan berita informasi mengenai asupan gizi harian dengan fokus pada edukasi gizi seimbang dan gaya hidup sehat berbasis bukti referensi artikel ilmiah dan ada sumber dari ahli gizi yaitu Indah Puji Lestari S.Gz. yang berperan sebagai talent dengan menyampaikan edukasi tentang kesehatan dan asupan gizi seimbang melalui berbagai konten edukatif di platform digital, khususnya Instagram, TikTok, (@gizila.id). Platform website Gizila memberikan edukasi dan kalkulasi gizi harian yang membantu masyarakat menjaga pola makan seimbang dengan fitur praktis dan modern.
                </p>
            </div>

            {{-- Konten Utama: Grid 2 Kolom --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- Kolom Kiri: Visi, Misi, Kontak --}}
                <div class="lg:col-span-10 flex flex-col gap-8">
                    
                        {{-- === BAGIAN VISI DIMODIFIKASI DI SINI === --}}
                <div class="bg-[#d6f6e4] rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <h2 class="text-3xl font-bold text-gray-800 mb-5 text-center">Visi Kami</h2>
                    <hr class="my-8 border-t-2 border-gray-300">
                    
                    {{-- === TAMBAHAN: Div untuk menampung ikon dan teks secara terpisah === --}}
                    <div class="text-center">
                        {{-- === TAMBAHAN: Ikon dengan posisi di tengah dan class animasi === --}}
                        <img src="{{ asset('assets/images/icons/visi.png') }}" alt="Visi" class="w-40 h-40 mx-auto animate-float">
                        
                        {{-- === TAMBAHAN: Class animasi pada teks === --}}
                        <p class="text-gray-600 leading-relaxed animate-fadeInUp">
                            Menjadi sumber inspirasi dan edukasi gizi serta kesehatan terpercaya di media sosial yang mengajak masyarakat hidup lebih sehat, cerdas, dan bahagia, melalui konten yang mudah dipahami, aplikatif, dan menyenangkan.
                        </p>
                    </div>
                </div>

                {{-- === BAGIAN MISI DIMODIFIKASI DI SINI === --}}
                <div class="bg-[#d6f6e4] rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <h2 class="text-3xl font-bold text-gray-800 mb-5 text-center">Misi Kami</h2>
                    <hr class="my-8 border-t-2 border-gray-300">
                    
                    <ul class="space-y-8 divide-y divide-gray-300">
                        {{-- Misi 1 --}}
                        <li class="pt-8 first:pt-0">
                            {{-- === TAMBAHAN: Struktur baru dengan ikon di atas teks === --}}
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('assets/images/icons/misi-1.png') }}" alt="Edukasi Gizi" class="w-40 h-40 mx-auto animate-float">
                                <div class="animate-fadeInUp">
                                    <h3 class="font-semibold text-2xl text-gray-700">Memberikan Edukasi Gizi yang Tepat & Terpercaya</h3>
                                    <p class="text-gray-600 leading-relaxed pt-1">Menyampaikan informasi gizi dan kesehatan berdasarkan ilmu yang valid, dibungkus dengan bahasa yang ringan dan mudah dipahami semua kalangan.</p> 
                                </div>
                            </div>
                        </li>
                        
                        {{-- Misi 2 --}}
                        <li class="pt-8 first:pt-0">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('assets/images/icons/misi-2.png') }}" alt="Hidup Sehat" class="w-40 h-40 mx-auto animate-float" style="animation-delay: 0.2s;">
                                <div class="animate-fadeInUp" style="animation-delay: 0.2s;">
                                    <h3 class="font-semibold text-2xl text-gray-700">Membentuk Kebiasaan Hidup Sehat</h3>
                                    <p class="text-gray-600 leading-relaxed pt-1">Mendorong masyarakat untuk mempraktikkan pola makan seimbang, cukup minum air, olahraga teratur, dan menjaga kesehatan mental.</p>
                                </div>
                            </div>
                        </li>
                        
                        {{-- Misi 3 --}}
                        <li class="pt-8 first:pt-0">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('assets/images/icons/misi-3.png') }}" alt="Konten Kreatif" class="w-40 h-40 mx-auto animate-float" style="animation-delay: 0.4s;">
                                <div class="animate-fadeInUp" style="animation-delay: 0.4s;">
                                    <h3 class="font-semibold text-2xl text-gray-700">Menginspirasi Melalui Konten Kreatif</h3>
                                    <p class="text-gray-600 leading-relaxed pt-1">Menghadirkan tips, infografis, dan ide sehat yang relevan dengan tren, sehingga audiens termotivasi untuk mencintai gaya hidup sehat.</p>
                                </div>
                            </div>
                        </li>
                        
                        {{-- Misi 4 --}}
                        <li class="pt-8 first:pt-0">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('assets/images/icons/misi-4.png') }}" alt="Komunitas Positif" class="w-40 h-40 mx-auto animate-float" style="animation-delay: 0.6s;">
                                <div class="animate-fadeInUp" style="animation-delay: 0.6s;">
                                    <h3 class="font-semibold text-2xl text-gray-700">Menjadi Komunitas Positif</h3>
                                    <p class="text-gray-600 leading-relaxed pt-1">Membuat ruang interaksi yang ramah dan suportif, tempat berbagi pengalaman dan saling memotivasi untuk menjaga kesehatan.</p>
                                </div>
                            </div>
                        </li>
                        
                        {{-- Misi 5 --}}
                        <li class="pt-8 first:pt-0">
                            <div class="flex flex-col items-center text-center">
                                <img src="{{ asset('assets/images/icons/misi-5.png') }}" alt="Kesehatan Menyeluruh" class="w-40 h-40 mx-auto animate-float" style="animation-delay: 0.8s;">
                                <div class="animate-fadeInUp" style="animation-delay: 0.8s;">
                                    <h3 class="font-semibold text-2xl text-gray-700">Mengedepankan Kesehatan yang Menyeluruh</h3>
                                    <p class="text-gray-600 leading-relaxed pt-1">Tidak hanya fokus pada nutrisi, tapi juga aktivitas fisik, istirahat, hidrasi, dan kesehatan mental, demi keseimbangan hidup.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                </div>

                {{-- Kolom Kanan: Kontak & Peta --}}
                <div class="lg:col-span-10 flex flex-col gap-8">
                    <div class="bg-[#d6f6e4] rounded-xl shadow-lg p-4 hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">Lokasi</h2>
                        
                        {{-- === TAMBAHAN #3: Tambahkan class untuk styling garis === --}}
                        <hr class="my-6 border-t-2 border-gray-300">
                        
                        <div class="w-full h-80 rounded-lg overflow-hidden border border-gray-200">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.044143499427!2d106.79973217478797!3d-6.38822159362701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e9518a563c43%3A0x10a51608873a0314!2sJl.%20Raya%20Keadilan%20No.A-17%2C%20Rangkapan%20Jaya%20Baru%2C%20Kec.%20Pancoran%20Mas%2C%20Kota%20Depok%2C%20Jawa%20Barat%2016434!5e0!3m2!1sid!2sid!4v1723438258359!5m2!1sid!2sid"
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                    
                    <div class="bg-[#d6f6e4] rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                        
                        {{-- === TAMBAHAN #4: Tambahkan class untuk styling garis === --}}
                        <hr class="my-6 border-t-2 border-gray-300">
                        
                        <div class="space-y-1">
                            <a href="https://maps.app.goo.gl/wEAb61k5iU33G6zN6" target="_blank" class="flex items-center gap-3 group">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-gizila-dark transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                <span class="text-gray-600 group-hover:text-gizila-dark transition">Jl. Raya Keadilan No. A-17, Pancoran Mas, Depok</span>
                            </a>
                            <a href="mailto:menujusehat@gmail.com" class="flex items-center gap-3 group">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-gizila-dark transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                                <span class="text-gray-600 group-hover:text-gizila-dark transition">menujusehat@gmail.com</span>
                            </a>
                                <a href="https://wa.me/6285856649859" target="_blank" class="flex items-center gap-3 group">
                                    <svg class="w-5 h-5 text-gray-500 group-hover:text-gizila-dark transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                                    <span class="text-gray-600 group-hover:text-gizila-dark transition">+62 858-5664-9859</span>
                                </a>
                        </div>
                        
                        {{-- === TAMBAHAN #5: Tambahkan class untuk styling garis === --}}
                        <hr class="my-6 border-t-2 border-gray-300">
                        
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Temukan Kami</h3>
                        
                        {{-- === TAMBAHAN #6: Tambahkan class untuk styling garis === --}}
                        <hr class="my-6 border-t-2 border-gray-300">
                        
                        {{-- Ikon Sosial Media --}}
                        <div class="flex items-center gap-4">
                            {{-- Instagram --}}
                            <a href="https://www.instagram.com/gizila.id/" target="_blank" class="hover:opacity-75">
                                <svg class="w-6 h-6 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M7.75 2A5.75 5.75 0 0 0 2 7.75v8.5A5.75 5.75 0 0 0 7.75 22h8.5A5.75 5.75 0 0 0 22 16.25v-8.5A5.75 5.75 0 0 0 16.25 2h-8.5Zm0 1.5h8.5A4.25 4.25 0 0 1 20.5 7.75v8.5A4.25 4.25 0 0 1 16.25 20.5h-8.5A4.25 4.25 0 0 1 3.5 16.25v-8.5A4.25 4.25 0 0 1 7.75 3.5ZM18 7a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-6 2a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm0 1.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Z"/>
                                </svg>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/company/pt-graisena-usahanusantara" target="_blank" class="hover:opacity-75">
                                <svg class="w-6 h-6 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5A2.5 2.5 0 0 0 2.5 6a2.5 2.5 0 0 0 5 0 2.5 2.5 0 0 0-2.52-2.5Zm.02 4.5H2.5v13h4.99V8H5ZM9 8h4.25v1.71h.06c.59-1.12 2.03-1.96 3.72-1.96 4 0 4.74 2.43 4.74 5.6v7.65H17.7v-6.78c0-1.62-.03-3.7-2.25-3.7-2.27 0-2.62 1.75-2.62 3.56v6.92H9V8Z"/>
                                </svg>
                            </a>

                            {{-- Facebook --}}
                            <a href="https://facebook.com/gizila" target="_blank" class="hover:opacity-75">
                                <svg class="w-6 h-6 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M15 2a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5h-2v-6h2.5a.5.5 0 0 0 .5-.5V13a.5.5 0 0 0-.5-.5H13v-1.8c0-.84.28-1.7 1.4-1.7H17a.5.5 0 0 0 .5-.5V6.6a.5.5 0 0 0-.5-.5h-2.14C11.69 6.1 11 8 11 10v2.5H9a.5.5 0 0 0-.5.5v1.5c0 .28.22.5.5.5h2V22H9a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5h6Z"/>
                                </svg>
                            </a>

                            {{-- X (Twitter) --}}
                            <a href="https://x.com/gizila" target="_blank" class="hover:opacity-75">
                                <svg class="w-6 h-6 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M19.82 3H22l-5.48 6.25L23 21h-6.59l-4.14-5.77L7.1 21H2l5.83-6.65L1 3h6.74l3.73 5.2L16.62 3h3.2ZM18 19.5h1.39L8.5 5h-1.5l11 14.5Z"/>
                                </svg>
                            </a>

                            {{-- TikTok --}}
                            <a href="https://www.tiktok.com/@gizila_?is_from_webapp=1&sender_device=pc" target="_blank" class="hover:opacity-75">
                                <svg class="w-6 h-6 fill-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12.83 2c.15 1.64.84 2.92 2.09 3.82 1.04.75 2.24 1.1 3.62 1.08v2.8c-.9.06-1.76-.08-2.59-.42a7.2 7.2 0 0 1-1.17-.63v7.92c0 2.26-1.03 3.82-3.08 4.66-1.57.64-3.17.55-4.78-.27C4.5 20.1 3.75 18.85 4.03 17.06c.3-2.01 1.52-3.3 3.67-3.84.69-.18 1.34-.18 1.97 0v2.75c-.3-.05-.58-.04-.83.04-.83.28-1.3.88-1.39 1.8-.06.7.2 1.25.8 1.63 1.01.64 2.25.3 2.73-.73.13-.3.2-.65.2-1.05V2h2.65Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
    
    {{-- Garis Pembatas --}}
    <div class="relative overflow-hidden border-t border-gizila-dark"></div>
        {{-- Copyright --}}
    <div class="bg-gizila-radial text-center py-4 relative z-10">
    <p class="text-xl font-semibold">
        <span class="text-font-semibold text-black">©</span>
        <span class="text-gizila-dark"><a href="/">GIZILA</a></span>
        <span class="text-font-semibold text-black">{{ date('Y') }}</span>
        {{-- <span class="text-font-semibold text-gray-600">All Rights Reserved.</span> --}}
    </p>
</div>
    </div>
</x-layout>