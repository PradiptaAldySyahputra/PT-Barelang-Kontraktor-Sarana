<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Carousel
    </h2>
    <nav>
        <ol class="flex items-center gap-1.5">
            <li>
                <a
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                    href="https://laravel-demo.tailadmin.com"
                >
                    Home
                    <svg
                        class="stroke-current rtl:rotate-180"
                        width="17"
                        height="16"
                        viewBox="0 0 17 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                            stroke=""
                            stroke-width="1.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90">
                Carousel
            </li>
        </ol>
    </nav>
</div>
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2 xl:gap-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Slides Only
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div x-data="uiCarousel(JSON.parse('{\u0022navigation\u0022:false,\u0022pagination\u0022:false,\u0022autoplay\u0022:5000}'))" class="rounded-lg border border-gray-200 dark:border-gray-800 carouselOne rounded-lg border border-gray-200 dark:border-gray-800">
    <div class="swiper" x-ref="container">
        <div class="swiper-wrapper"><div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-01.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-02.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-03.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-04.png" class="w-full rounded-lg" alt="carousel" />
            </div></div></div>
            </div>
    </div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            With Controls
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div x-data="uiCarousel(JSON.parse('{\u0022navigation\u0022:true,\u0022pagination\u0022:false,\u0022autoplay\u0022:5000}'))" class="rounded-lg border border-gray-200 dark:border-gray-800 carouselTwo relative rounded-lg border border-gray-200 dark:border-gray-800">
    <div class="swiper" x-ref="container">
        <div class="swiper-wrapper"><div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-01.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-02.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-03.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-04.png" class="w-full rounded-lg" alt="carousel" />
            </div></div></div>
            </div>
            <div class="swiper-button-prev prev-style-one" x-ref="prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6!">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        </div>
        <div class="swiper-button-next next-style-one" x-ref="next">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6!">
    <path d="M9 18l6-6-6-6" />
  </svg>
        </div>
    </div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            With Indicators
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div x-data="uiCarousel(JSON.parse('{\u0022navigation\u0022:false,\u0022pagination\u0022:true,\u0022autoplay\u0022:5000}'))" class="rounded-lg border border-gray-200 dark:border-gray-800 carouselThree relative rounded-lg border border-gray-200 dark:border-gray-800">
    <div class="swiper" x-ref="container">
        <div class="swiper-wrapper"><div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-01.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-02.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-03.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-04.png" class="w-full rounded-lg" alt="carousel" />
            </div></div></div>
        <div class="swiper-pagination" x-ref="pagination"></div>    </div>
    </div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            With Controls and Indicators
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div x-data="uiCarousel(JSON.parse('{\u0022navigation\u0022:true,\u0022pagination\u0022:true,\u0022autoplay\u0022:5000}'))" class="rounded-lg border border-gray-200 dark:border-gray-800 carouselFour relative rounded-lg border border-gray-200 dark:border-gray-800">
    <div class="swiper" x-ref="container">
        <div class="swiper-wrapper"><div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-01.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-02.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-03.png" class="w-full rounded-lg" alt="carousel" />
            </div></div>
            <div class="swiper-slide" ><div class="overflow-hidden rounded-lg">
                <img width="487" height="297" src="/assets/images/carousel/carousel-04.png" class="w-full rounded-lg" alt="carousel" />
            </div></div></div>
        <div class="swiper-pagination" x-ref="pagination"></div>    </div>
            <div class="swiper-button-prev prev-style-one" x-ref="prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6!">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        </div>
        <div class="swiper-button-next next-style-one" x-ref="next">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6!">
    <path d="M9 18l6-6-6-6" />
  </svg>
        </div>
    </div>
        </div>
    </div>
</div>    </div>

            </div>
        </div>

    </div>

</body>


</html>
