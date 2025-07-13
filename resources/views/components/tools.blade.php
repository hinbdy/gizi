<section id="Tool" class="py-16 bg-gizila-radial overflow-hidden">
    <div class="text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            <span class="relative inline-block">
                Powered By:
                <span class="absolute bottom-[-8px] left-0 h-1.5 w-full origin-left scale-x-0 transform bg-gizila-dark transition-transform duration-500 ease-in-out animate-draw-line"></span>
            </span>
        </h2>

        <div x-data="{ activeMarquee: 1 }" 
             x-init="setInterval(() => { activeMarquee = activeMarquee === 1 ? 2 : 1 }, 8000)" 
             class="relative mt-16 h-24">

            <template x-if="activeMarquee === 1">
                <div class="w-full">
                     <marquee behavior="scroll" direction="left" scrollamount="25">
                        <img src="{{ asset('assets/images/logos/guntara.png') }}" alt="Guntara Logo" class="h-20">
                    </marquee>
                </div>
            </template>

            <template x-if="activeMarquee === 2">
                <div class="w-full">
                     <marquee behavior="scroll" direction="left" scrollamount="25">
                        <img src="{{ asset('assets/images/logos/gizila.png') }}" alt="Gizila Logo" class="h-20">
                    </marquee>
                </div>
            </template>
        </div>
    </div>
</section>