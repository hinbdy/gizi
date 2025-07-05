<section id="Tool" class="mb-[102px] flex flex-col gap-8">
  <div class="container max-w-[1130px] mx-auto flex justify-between items-center">
    <h2 class="font-semibold text-[32px]">Browse Tools</h2>
  </div>
  <div class="tools-logos w-full overflow-hidden flex flex-col gap-5">
    <div class="group/slider flex flex-nowrap w-max items-center">
      <div class="logo-container animate-[slide_50s_linear_infinite] group-hover/slider:pause-animate flex gap-5 pl-5 items-center flex-nowrap">
        @foreach ([
          'figma.svg', 'adobe-xd.svg', 'photoshop.svg', 'illustrator.svg', 'framer.png', 'webflow.svg',
          'figma.svg', 'adobe-xd.svg', 'photoshop.svg', 'illustrator.svg', 'framer.png', 'webflow.svg'
        ] as $tool)
          <a href="#" class="group tool-card w-fit h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
            <div class="p-4 bg-[#1E1E1E] rounded-2xl flex items-center justify-center w-[96px] h-[96px]">
              <img src="{{ asset('assets/images/logos/' . $tool) }}" alt="tool-logo" class="max-w-[56px] max-h-[56px]">
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
