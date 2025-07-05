<section 
  x-data="{ index: 0, slides: 3 }"
  x-init="setInterval(() => { index = (index + 1) % slides }, 5000)"
  class="relative w-full aspect-[16/9] md:aspect-[15/10] overflow-hidden">

<div class="absolute top-0 left-0 h-full w-[3px] bg-green-600 shadow-[0_0_10px_2px_rgba(34,197,94,0.6)] z-20"></div>
<div class="absolute top-0 right-0 h-full w-[3px] bg-green-600 shadow-[0_0_10px_2px_rgba(34,197,94,0.6)] z-20"></div>


  {{-- Carousel wrapper --}}
  <div 
  class="w-full h-full flex transition-transform duration-1000 ease-in-out"
  :style="`transform: translateX(-${index * 100}%);`"
>
  {{-- Slide 1 --}}
  <a href="{{ route('bmi.calculator') }}" class="min-w-full h-full relative">
    <img src="{{ asset('assets/images/iklan-bmi.png') }}" alt="BMI" class="w-full h-full object-cover object-center" />
    <div class="absolute inset-0 bg-black/40"></div>
  </a>

  {{-- Slide 2 --}}
  <a href="{{ route('nutrition.calculator') }}" class="min-w-full h-full relative">
    <img src="{{ asset('assets/images/gizi.png') }}" alt="Gizi" class="w-full h-full object-cover object-center" />
    <div class="absolute inset-0 bg-black/40"></div>
  </a>

  {{-- Slide 3 --}}
  <a href="{{ route('blog.index') }}" class="min-w-full h-full relative">
    <img src="{{ asset('assets/images/iklan-artikel.png') }}" alt="Artikel" class="w-full h-full object-cover object-center" />
    <div class="absolute inset-0 bg-black/40"></div>
  </a>
</div>


  {{-- Navigasi panah --}}
  <button @click="index = (index - 1 + slides) % slides"
    class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md z-30">
    &#10094;
  </button>
  <button @click="index = (index + 1) % slides"
    class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md z-30">
    &#10095;
  </button>

  {{-- Dot Pagination --}}
  <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-30">
    <template x-for="i in slides" :key="i">
      <div @click="index = i - 1"
        class="w-3 h-3 rounded-full cursor-pointer"
        :class="{
          'bg-white': index === i - 1,
          'bg-gray-400': index !== i - 1
        }"></div>
    </template>
  </div>
</section>
