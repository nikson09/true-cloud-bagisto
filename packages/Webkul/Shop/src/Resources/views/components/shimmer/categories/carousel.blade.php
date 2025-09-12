@props(['count' => 0])

<div class="container mt-14 max-lg:px-8 max-md:mt-7 max-md:!px-0 max-sm:mt-5">
    <!-- Header Shimmer -->
    <div class="mb-8 flex items-center justify-between">
        <div class="shimmer h-8 w-48 rounded-lg max-md:h-6 max-md:w-36 max-sm:h-5 max-sm:w-28"></div>
        <div class="shimmer h-5 w-24 rounded-lg"></div>
    </div>

    <div class="relative">
        <!-- Desktop Shimmer -->
        <div class="scrollbar-hide flex gap-6 overflow-auto max-lg:hidden">
            @for ($i = 0;  $i < $count; $i++)
                <div class="min-w-[280px] max-w-[280px]">
                    <div class="shimmer relative h-[200px] w-full overflow-hidden rounded-xl bg-gray-100">
                        <!-- Text overlay shimmer -->
                        <div class="absolute bottom-3 left-4">
                            <div class="shimmer h-6 w-16 rounded-md"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Mobile Shimmer -->
        <div class="scrollbar-hide flex gap-10 overflow-auto lg:hidden max-lg:gap-4">
            @for ($i = 0;  $i < $count; $i++)
                <div class="grid min-w-[120px] grid-cols-1 justify-items-center gap-4 max-md:min-w-20 max-md:gap-2.5 max-md:first:ml-4 max-sm:min-w-[60px] max-sm:max-w-[60px] max-sm:gap-1.5">
                    <div class="shimmer relative h-[110px] w-[110px] overflow-hidden rounded-full max-md:h-20 max-md:w-20 max-sm:h-[60px] max-sm:w-[60px]">
                        <img class="rounded-sm bg-zinc-100">
                    </div>

                    <p class="shimmer h-[27px] w-[90px] rounded-2xl max-sm:h-5 max-sm:w-[70px]"></p>
                </div>
            @endfor
        </div>

        <span
            class="shimmer absolute -left-10 top-1/2 -translate-y-1/2 flex h-[50px] w-[50px] rounded-full max-sm:hidden"
            role="presentation"
        ></span>

        <span
            class="shimmer absolute -right-6 top-1/2 -translate-y-1/2 flex h-[50px] w-[50px] rounded-full max-sm:hidden"
            role="presentation"
        ></span>
    </div>
</div>

