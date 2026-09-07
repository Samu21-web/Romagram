<section style="min-height:88vh; position:relative; overflow:hidden;">

    <!-- Background image -->
    <div style="position:absolute; inset:0; background:url('{{ asset('images/love.webp') }}') center right/cover no-repeat;"></div>

    <!-- Overlay -->
    <div style="position:absolute; inset:0; background:linear-gradient(to right, rgba(10,5,30,0.90) 0%, rgba(10,5,30,0.80) 45%, rgba(10,5,30,0.3) 70%, transparent 100%);"></div>

    <!-- Content -->
    <div class="relative z-10">

        <!-- Top Bar -->
        <div class="flex items-center justify-between px-6 py-4 md:px-12 md:py-5">

            <a href="/" class="no-underline">
                <img src="{{ asset('logo.png') }}" alt="Romagram" class="h-12 md:h-20">
            </a>

            <div class="flex items-center gap-2 md:gap-3">

                <span class="hidden md:block text-white font-extrabold text-lg">
                    Have an account?
                </span>

                <a href="#"
                   onclick="openModal('loginModal')"
                   class="text-sm md:text-lg font-bold px-4 py-2 md:px-6 md:py-2 rounded-lg text-white no-underline transition-all hover:bg-white/10"
                   style="border:1.5px solid rgba(255,255,255,.5);">
                    Sign in
                </a>

            </div>

        </div>

<!-- Hero -->
<div class="px-6 pt-6 pb-8 md:px-12 md:pt-12 md:pb-16 max-w-xl md:max-w-[560px]">

    <!-- MOBILE TITLE -->
    <div class="md:hidden mb-6">

        <p class="text-center text-cyan-300 text-sm font-bold tracking-widest uppercase mb-4">
            Find Genuine Love
        </p>

<div class="space-y-2 max-w-sm mx-auto">

    <div class="bg-[#720e9e] py-2 px-3 -rotate-2 shadow-lg">
        <h1 class="text-center text-white font-black uppercase tracking-tight leading-none text-[2.2rem]">
            Find Love
        </h1>
    </div>

    <div class="bg-white py-2 px-3 rotate-1 shadow-lg">
        <h1 class="text-center text-[#720e9e] font-black uppercase tracking-tight leading-none text-[2.2rem]">
            At Your
        </h1>
    </div>

    <div class="bg-[#720e9e] py-2 px-3 -rotate-1 shadow-lg">
        <h1 class="text-center text-white font-black uppercase tracking-tight leading-none text-[2.2rem]">
            Own Pace
        </h1>
    </div>

</div>

    </div>

    <!-- DESKTOP TITLE -->
    <div class="hidden md:block">

        <h1 class="font-extrabold text-white leading-tight mb-3 md:mb-4"
            style="font-size:clamp(28px,7vw,56px);line-height:1.1;">
            Find Love at <br>
            <span style="color:#961BCF;">Your Own Pace</span>
        </h1>

        <p class="text-sm md:text-lg text-white/70 mb-6 md:mb-8 leading-relaxed max-w-sm md:max-w-[460px]">
            Connecting real people for genuine relationships. No games, no bots, just meaningful connections worldwide.
        </p>

        <a href="#"
           onclick="openModal('registerModal')"
           class="inline-flex items-center gap-2 text-white font-bold rounded-lg no-underline transition-all hover:opacity-90"
           style="background:#720e9e;
                  font-size:clamp(14px,4vw,18px);
                  padding:clamp(11px,3vw,14px) clamp(20px,5vw,40px);
                  box-shadow:0 4px 20px rgba(114,14,158,.4);">

            <i class="fa-solid fa-heart"></i>

            Join Romagram Free

        </a>

    </div>

    <!-- MOBILE IMAGE -->
    <div class="md:hidden mt-6">

        <div class="overflow-hidden border border-black/10 bg-black/10 backdrop-blur-2xl shadow-2xl">

            <img src="{{ asset('images/mobile.webp') }}"
                 class="w-full h-64 object-cover"
                 alt="Romagram">

        </div>

        <!-- PURPLE BUTTON -->
        <div class="mt-4 bg-gradient-to-r from-[#720e9e] to-[#9018be] p-4 shadow-2xl">

            <a href="#"
               onclick="openModal('registerModal')"
               class="flex items-center justify-center gap-2 w-full py-4 text-xl font-bold text-white no-underline"
               style="background:linear-gradient(135deg,#9018be,#720e9e);">

                <i class="fa-solid fa-heart"></i>

                Join Romagram Free

            </a>

        </div>

    </div>

</div>

        <!-- DESKTOP FEATURE CARDS -->
        <div class="hidden md:block px-4 pb-10 md:px-12 md:pb-0 -mt-2">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-0 max-w-[1400px] mx-auto overflow-hidden md:rounded md:border md:border-white/10 md:shadow-2xl md:backdrop-blur-xl">

                <!-- Card 1 -->
                <div class="px-5 py-6 md:px-8 md:py-10 text-white flex items-start gap-4 md:flex-col md:gap-0 md:text-center"
                     style="background:linear-gradient(135deg,#720e9e,#320a50);">

                    <div class="w-10 h-10 md:w-14 md:h-14 rounded-full border-2 border-white/80 flex items-center justify-center flex-shrink-0 text-base md:text-2xl md:mx-auto md:mb-4 mt-0.5">

                        <i class="fa-solid fa-heart"></i>

                    </div>

                    <div class="text-left md:text-center">

                        <h3 class="text-sm md:text-2xl font-extrabold">
                            Built for Genuine Connections
                        </h3>

                    </div>

                </div>

                <!-- Card 2 -->
                <div class="px-5 py-6 md:px-8 md:py-10 text-white flex items-start gap-4 md:flex-col md:gap-0 md:text-center md:border-x md:border-white/10"
                     style="background:linear-gradient(135deg,#9018be,#720e9e);">

                    <div class="w-10 h-10 md:w-14 md:h-14 rounded-full border-2 border-white/80 flex items-center justify-center flex-shrink-0 text-base md:text-2xl md:mx-auto md:mb-4 mt-0.5">

                        <i class="fa-solid fa-globe"></i>

                    </div>

                    <div class="text-left md:text-center">

                        <h3 class="text-sm md:text-2xl font-extrabold">
                            Meet People Worldwide
                        </h3>

                    </div>

                </div>

                <!-- Card 3 -->
                <div class="px-5 py-6 md:px-8 md:py-10 text-white flex items-start gap-4 md:flex-col md:gap-0 md:text-center"
                     style="background:linear-gradient(135deg,#320a50,#720e9e);">

                    <div class="w-10 h-10 md:w-14 md:h-14 rounded-full border-2 border-white/80 flex items-center justify-center flex-shrink-0 text-base md:text-2xl md:mx-auto md:mb-4 mt-0.5">

                        <i class="fa-solid fa-shield-halved"></i>

                    </div>

                    <div class="text-left md:text-center">

                        <h3 class="text-sm md:text-2xl font-extrabold">
                            Safe, Private & Simple
                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>