<v-categories-carousel
    src="{{ $src }}"
    title="{{ $title }}"
    navigation-link="{{ $navigationLink ?? '' }}"
>
    <x-shop::shimmer.categories.carousel
        :count="8"
        :navigation-link="$navigationLink ?? false"
    />
</v-categories-carousel>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-categories-carousel-template"
    >
        <div
            class="container mt-14 max-lg:px-8 max-md:mt-7 max-md:!px-0 max-sm:mt-5"
            v-if="! isLoading && categories?.length"
        >
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <h2 class="text-3xl font-bold text-black max-md:text-2xl max-sm:text-xl">
                    @lang('shop::app.categories.carousel.title')
                </h2>
            </div>

            <!-- Categories Grid -->
            <div class="relative">
                <!-- Desktop Layout -->
                <div
                    ref="swiperContainer"
                    class="scrollbar-hide flex gap-6 overflow-auto scroll-smooth max-lg:hidden"
                >
                    <div
                        class="min-w-[280px] max-w-[280px]"
                        v-for="category in categories"
                    >
                        <a
                            :href="category.slug"
                            class="group block relative overflow-hidden rounded-xl bg-gray-100 transition-transform duration-300 hover:scale-105"
                            :aria-label="category.name"
                        >
                            <!-- Category Image -->
                            <div class="relative h-[200px] w-full">
                                <x-shop::media.images.lazy
                                    ::src="category.logo?.large_image_url || '{{ bagisto_asset('images/small-product-placeholder.webp') }}'"
                                    width="280"
                                    height="200"
                                    class="w-full h-full object-cover"
                                    ::alt="category.name"
                                />

                                <!-- Text Overlay -->
                                <div class="absolute bottom-3 left-4">
                                    <div class="bg-white/90 rounded-md px-2.5 py-1.5 shadow-sm" style="    background: whitesmoke;opacity: 0.8;margin-left: 1vw;">
                                        <p
                                            class="text-xs font-medium text-black"
                                            v-text="category.name"
                                        >
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Mobile Layout -->
                <div
                    ref="swiperContainerMobile"
                    class="scrollbar-hide flex gap-12 overflow-auto scroll-smooth lg:hidden max-lg:gap-4"
                >
                    <div
                        class="grid min-w-[120px] max-w-[120px] grid-cols-1 justify-items-center gap-4 font-medium max-md:min-w-20 max-md:max-w-20 max-md:gap-2.5 max-md:first:ml-4 max-sm:min-w-[60px] max-sm:max-w-[60px] max-sm:gap-1.5"
                        v-for="category in categories"
                    >
                        <a
                            :href="category.slug"
                            class="h-[110px] w-[110px] rounded-full bg-zinc-100 max-md:h-20 max-md:w-20 max-sm:h-[60px] max-sm:w-[60px]"
                            :aria-label="category.name"
                        >
                            <x-shop::media.images.lazy
                                ::src="category.logo?.large_image_url || '{{ bagisto_asset('images/small-product-placeholder.webp') }}'"
                                width="110"
                                height="110"
                                class="w-full rounded-full max-sm:h-[60px] max-sm:w-[60px]"
                                ::alt="category.name"
                            />
                        </a>

                        <a
                            :href="category.slug"
                            class=""
                        >
                            <p
                                class="text-center text-lg text-black max-md:text-base max-md:font-normal max-sm:text-sm"
                                v-text="category.name"
                            >
                            </p>
                        </a>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <span
                    class="icon-arrow-left-stylish absolute -left-10 top-1/2 -translate-y-1/2 flex h-[50px] w-[50px] cursor-pointer items-center justify-center rounded-full border border-black bg-white text-2xl transition hover:bg-black hover:text-white max-lg:-left-7 max-md:hidden"
                    role="button"
                    aria-label="@lang('shop::components.carousel.previous')"
                    tabindex="0"
                    @click="swipeLeft"
                >
                </span>

                <span
                    class="icon-arrow-right-stylish absolute -right-6 top-1/2 -translate-y-1/2 flex h-[50px] w-[50px] cursor-pointer items-center justify-center rounded-full border border-black bg-white text-2xl transition hover:bg-black hover:text-white max-lg:-right-7 max-md:hidden"
                    role="button"
                    aria-label="@lang('shop::components.carousel.next')"
                    tabindex="0"
                    @click="swipeRight"
                >
                </span>
            </div>
        </div>

        <!-- Category Carousel Shimmer -->
        <template v-if="isLoading">
            <x-shop::shimmer.categories.carousel
                :count="8"
                :navigation-link="$navigationLink ?? false"
            />
        </template>
    </script>

    <script type="module">
        app.component('v-categories-carousel', {
            template: '#v-categories-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
            ],

            data() {
                return {
                    isLoading: true,

                    categories: [],

                    offset: 300, // Updated offset for new card width
                };
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;

                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                swipeLeft() {
                    const container = this.$refs.swiperContainer;
                    const mobileContainer = this.$refs.swiperContainerMobile;

                    if (container) {
                        container.scrollLeft -= this.offset;
                    }
                    if (mobileContainer) {
                        mobileContainer.scrollLeft -= 323; // Original mobile offset
                    }
                },

                swipeRight() {
                    const container = this.$refs.swiperContainer;
                    const mobileContainer = this.$refs.swiperContainerMobile;

                    if (container) {
                        container.scrollLeft += this.offset;
                    }
                    if (mobileContainer) {
                        mobileContainer.scrollLeft += 323; // Original mobile offset
                    }
                },
            },
        });
    </script>
@endPushOnce
