{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.before') !!}

<!-- Isolated Topbar with unique CSS classes -->
<div class="tc-topbar-container w-full w-100">
    <div class="tc-topbar-wrapper container flex items-center gap-3 relative">
        <div class="tc-topbar-left">
            <span class="tc-topbar-delivery">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tc-topbar-icon">
                    <path d="M12 6v6l4 2"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
@lang('shop::app.components.layouts.header.desktop.bottom.topbar.delivery')
            </span>
<span class="tc-topbar-guarantee">@lang('shop::app.components.layouts.header.desktop.bottom.topbar.guarantee')</span>
        </div>
        <div class="tc-topbar-right">
            <a href="javascript:void(0)" onClick="changeLocale('ru')" class="tc-topbar-link">RU</a>
            <a href="javascript:void(0)" onClick="changeLocale('uk')" class="tc-topbar-link">UA</a>
            <a href="tel:+380111222333" class="tc-topbar-link">+380 111 222 333</a>
        </div>
    </div>
</div>

<div class="sticky top-0 z-50 bg-white/90 border-b border-slate-100 w-full min-h-[78px] max-[1180px]:px-8 container">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex h-16 items-center gap-3 relative">
        <!-- Logo Section -->
        <a
            class="relative flex flex-shrink-0"
            href="{{ route('shop.home.index') }}"
            aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.bagisto')"
        >
            <img src="/logo.png" alt="True Cloud" class="h-12 w-auto" style="margin-right: 10px;" >
            <div class="block">
                <div class="text-xl font-extrabold tracking-tight text-slate-900">True Cloud</div>
                <div class="text-xs text-slate-500 font-medium">EST. 2015</div>
            </div>
        </a>

        <!-- Center Search Bar -->
        <div class="hidden flex-1 items-center justify-center lg:flex">
            <div class="relative w-full max-w-[450px]">
                <form
                    action="{{ route('shop.search.index') }}"
                    class="flex items-center bg-gray-50 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200"
                    role="search"
                >
                    <label
                        for="organic-search"
                        class="sr-only"
                    >
                        @lang('shop::app.components.layouts.header.desktop.bottom.search')
                    </label>

                    <!-- Search Icon -->
                    <div style="margin-left: 10px;" class="icon-search pointer-events-none flex items-center text-gray-400 text-lg ltr:ml-4 rtl:mr-4"></div>

                    <!-- Search Input -->
                    <input
                        type="text"
                        name="query"
                        value="{{ request('query') }}"
                        class="flex-1 bg-transparent px-3 py-3 text-sm text-gray-900 placeholder-gray-500 focus:outline-none"
                        minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                        maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}"
                        placeholder="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-required="true"
                        pattern="[^\\]+"
                        required
                    >

                    <!-- Search Button -->
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-r-xl transition-all duration-300 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md hover:shadow-lg"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.submit')"
                        style="background-color: rgb(255 107 53 / var(--tw-bg-opacity, 1));border-radius: .75rem;"
                    >
@lang('shop::app.components.layouts.header.desktop.bottom.topbar.search-btn')
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Navigation Links -->
        <div class="mt-1.5 flex gap-x-8 max-[1100px]:gap-x-6 max-lg:gap-x-8 flex-shrink-0">

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.before') !!}

            <!-- Compare -->
            @if(core()->getConfigData('catalog.products.settings.compare_option'))
                <a
                    href="{{ route('shop.compare.index') }}"
                    aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.compare')"
                >
                    <span
                        class="icon-compare inline-block cursor-pointer text-2xl"
                        role="presentation"
                    ></span>
                </a>
            @endif

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.before') !!}

            <!-- Mini cart -->
            @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                @include('shop::checkout.cart.mini-cart')
            @endif

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.before') !!}

            <!-- user profile -->
            <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                <x-slot:toggle>
                    <span
                        class="icon-users inline-block cursor-pointer text-2xl"
                        role="button"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.profile')"
                        tabindex="0"
                    ></span>
                </x-slot>

                <!-- Guest Dropdown -->
                @guest('customer')
                    <x-slot:content>
                        <div class="grid gap-2.5">
                            <p class="font-dmserif text-xl">
                                @lang('shop::app.components.layouts.header.desktop.bottom.welcome-guest')
                            </p>

                            <p class="text-sm">
                                @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                            </p>
                        </div>

                        <p class="mt-3 w-full border border-zinc-200"></p>

                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.before') !!}

                        <div class="mt-6 flex gap-4">
                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_in_button.before') !!}

                            <a
                                href="{{ route('shop.customer.session.create') }}"
                                class="primary-button m-0 mx-auto block w-max rounded-2xl px-7 text-center text-base max-md:rounded-lg ltr:ml-0 rtl:mr-0"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.sign-in')
                            </a>

                            <a
                                href="{{ route('shop.customers.register.index') }}"
                                class="secondary-button m-0 mx-auto block w-max rounded-2xl border-2 px-7 text-center text-base max-md:rounded-lg max-md:py-3 ltr:ml-0 rtl:mr-0"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.sign-up')
                            </a>

                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_up_button.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.after') !!}
                    </x-slot>
                @endguest

                <!-- Customers Dropdown -->
                @auth('customer')
                    <x-slot:content class="!p-0">
                        <div class="grid gap-2.5 p-5 pb-0">
                            <p class="font-dmserif text-xl">
                                @lang('shop::app.components.layouts.header.desktop.bottom.welcome')’
                                {{ auth()->guard('customer')->user()->first_name }}
                            </p>

                            <p class="text-sm">
                                @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                            </p>
                        </div>

                        <p class="mt-3 w-full border border-zinc-200"></p>

                        <div class="mt-2.5 grid gap-1 pb-2.5">
                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.before') !!}

                            <a
                                class="cursor-pointer px-5 py-2 text-base hover:bg-gray-100"
                                href="{{ route('shop.customers.account.profile.index') }}"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.profile')
                            </a>

                            <a
                                class="cursor-pointer px-5 py-2 text-base hover:bg-gray-100"
                                href="{{ route('shop.customers.account.orders.index') }}"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.orders')
                            </a>

                            @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                <a
                                    class="cursor-pointer px-5 py-2 text-base hover:bg-gray-100"
                                    href="{{ route('shop.customers.account.wishlist.index') }}"
                                >
                                    @lang('shop::app.components.layouts.header.desktop.bottom.wishlist')
                                </a>
                            @endif

                            <!--Customers logout-->
                            @auth('customer')
                                <x-shop::form
                                    method="DELETE"
                                    action="{{ route('shop.customer.session.destroy') }}"
                                    id="customerLogout"
                                />

                                <a
                                    class="cursor-pointer px-5 py-2 text-base hover:bg-gray-100"
                                    href="{{ route('shop.customer.session.destroy') }}"
                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                >
                                    @lang('shop::app.components.layouts.header.desktop.bottom.logout')
                                </a>
                            @endauth

                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.after') !!}
                        </div>
                    </x-slot>
                @endauth
            </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.after') !!}
        </div>
        </div>

        <!-- Desktop nav -->
        <v-desktop-category>
            <div class="flex items-center gap-5">
                <span
                    class="shimmer h-6 w-20 rounded"
                    role="presentation"
                ></span>

                <span
                    class="shimmer h-6 w-20 rounded"
                    role="presentation"
                ></span>

                <span
                    class="shimmer h-6 w-20 rounded"
                    role="presentation"
                ></span>
            </div>
        </v-desktop-category>
    </div>
    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden border-t border-slate-100 bg-white lg:hidden">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <div class="mb-3">
                <input class="w-full rounded-2xl border border-slate-200 bg-slate-50/60 py-2.5 px-3 outline-none ring-primary/20 focus:ring-2" placeholder="@lang('shop::app.components.layouts.header.desktop.bottom.topbar.search-placeholder')" />
            </div>
            <ul class="grid grid-cols-2 gap-3 text-[15px] font-medium">
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=hookahs">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.hookahs')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=tobacco">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.tobacco')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=coal">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.coal')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=bowls">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.bowls')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=hoses">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.hoses')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=accessories">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.accessories')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?category=kits">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.kits')</a></li>
                <li><a class="block rounded-xl bg-slate-50 p-3" href="?sale=1">@lang('shop::app.components.layouts.header.desktop.bottom.mobile-menu.sale')</a></li>
            </ul>
        </div>
    </div>

</div>
@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-desktop-category-template"
    >
        <!-- Loading State -->
        <div
            class="flex items-center gap-5"
            v-if="isLoading"
        >
            <span
                class="shimmer h-6 w-20 rounded"
                role="presentation"
            ></span>

            <span
                class="shimmer h-6 w-20 rounded"
                role="presentation"
            ></span>

            <span
                class="shimmer h-6 w-20 rounded"
                role="presentation"
            ></span>
        </div>
        <div v-else-if="'{{ core()->getConfigData('general.design.categories.category_view') }}' !== 'sidebar'">
            <nav class="hidden items-center justify-between gap-8 pb-3 lg:flex">
                <ul class="flex flex-wrap items-center justify-center gap-5 text-[15px] font-medium">
                    <li v-for="category in categories" :key="category.id" class="group relative category">
                        <a class="hover:text-primary" :href="category.url">@{{ category.name }}</a>
                        <div
                            class="pointer-events-none absolute top-full left-0 z-[1] max-h-[580px] w-max max-w-[1260px] translate-y-1 overflow-auto overflow-x-auto border border-b-0 border-l-0 border-r-0 border-t border-[#F3F3F3] bg-white p-9 opacity-0 shadow-[0_6px_6px_1px_rgba(0,0,0,.3)] transition duration-300 ease-out group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100 group-hover:duration-200 group-hover:ease-in"
                            v-if="category.children && category.children.length"
                        >
                            <div class="flex justify-between gap-x-[70px]">
                                <div
                                    class="grid w-full min-w-max max-w-[150px] flex-auto grid-cols-[1fr] content-start gap-5"
                                    v-for="pairCategoryChildren in pairCategoryChildren(category)"
                                >
                                    <template v-for="secondLevelCategory in pairCategoryChildren">
                                        <p class="font-medium text-navyBlue">
                                            <a :href="secondLevelCategory.url">
                                                @{{ secondLevelCategory.name }}
                                            </a>
                                        </p>

                                        <ul
                                            class="grid grid-cols-[1fr] gap-3"
                                            v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                        >
                                            <li
                                                class="text-sm font-medium text-zinc-500"
                                                v-for="thirdLevelCategory in secondLevelCategory.children"
                                            >
                                                <a :href="thirdLevelCategory.url">
                                                    @{{ thirdLevelCategory.name }}
                                                </a>
                                            </li>
                                        </ul>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="hidden gap-6 text-sm text-slate-500 xl:flex ml-8">
                    <span class="inline-flex items-center gap-2"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15V6"/><path d="M3 9v9"/><path d="M7 12v3"/><path d="M17 3v12"/></svg> @lang('shop::app.components.layouts.header.desktop.bottom.topbar.top-sales')</span>
                    <span class="inline-flex items-center gap-2"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> @lang('shop::app.components.layouts.header.desktop.bottom.topbar.new-items')</span>
                    <span class="inline-flex items-center gap-2"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg> @lang('shop::app.components.layouts.header.desktop.bottom.topbar.fast-delivery')</span>
                </div>
            </nav>
        </div>

        <!-- Sidebar category layout -->
        <div v-else>
            <!-- Categories Navigation -->
            <div class="flex items-center">
                <!-- "All" button for opening the category drawer -->
                <div
                    class="flex h-[77px] cursor-pointer items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue"
                    @click="toggleCategoryDrawer"
                >
                    <span class="flex items-center gap-1 px-5 uppercase">
                        <span class="icon-hamburger text-xl"></span>

                        @lang('shop::app.components.layouts.header.desktop.bottom.all')
                    </span>
                </div>

                <!-- Show only first 4 categories in main navigation -->
                <div
                    class="group relative flex h-[77px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue"
                    v-for="category in categories.slice(0, 4)"
                    :key="category.id"
                >
                    <span>
                        <a
                            :href="category.url"
                            class="inline-block px-5 uppercase"
                        >
                            @{{ category.name }}
                        </a>
                    </span>

                    <!-- Dropdown for each category -->
                    <div
                        class="pointer-events-none absolute top-full left-0 z-[1] max-h-[580px] w-max max-w-[1260px] translate-y-1 overflow-auto overflow-x-auto border border-b-0 border-l-0 border-r-0 border-t border-[#F3F3F3] bg-white p-9 opacity-0 shadow-[0_6px_6px_1px_rgba(0,0,0,.3)] transition duration-300 ease-out group-hover:pointer-events-auto group-hover:translate-y-0 group-hover:opacity-100 group-hover:duration-200 group-hover:ease-in"
                        v-if="category.children && category.children.length"
                    >
                        <div class="flex justify-between gap-x-[70px]">
                            <div
                                class="grid w-full min-w-max max-w-[150px] flex-auto grid-cols-[1fr] content-start gap-5"
                                v-for="pairCategoryChildren in pairCategoryChildren(category)"
                            >
                                <template v-for="secondLevelCategory in pairCategoryChildren">
                                    <p class="font-medium text-navyBlue">
                                        <a :href="secondLevelCategory.url">
                                            @{{ secondLevelCategory.name }}
                                        </a>
                                    </p>

                                    <ul
                                        class="grid grid-cols-[1fr] gap-3"
                                        v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                    >
                                        <li
                                            class="text-sm font-medium text-zinc-500"
                                            v-for="thirdLevelCategory in secondLevelCategory.children"
                                        >
                                            <a :href="thirdLevelCategory.url">
                                                @{{ thirdLevelCategory.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagisto Drawer Integration -->
            <x-shop::drawer
                position="left"
                width="400px"
                ::is-active="isDrawerActive"
                @toggle="onDrawerToggle"
                @close="onDrawerClose"
            >
                <x-slot:toggle></x-slot>

                <x-slot:header class="border-b border-gray-200">
                    <div class="flex w-full items-center justify-between">
                        <p class="text-xl font-medium">
                            @lang('shop::app.components.layouts.header.desktop.bottom.categories')
                        </p>
                    </div>
                </x-slot>

                <x-slot:content class="!px-0">
                    <!-- Wrapper with transition effects -->
                    <div class="relative h-full overflow-hidden">
                        <!-- Sliding container -->
                        <div
                            class="flex h-full transition-transform duration-300"
                            :class="{
                                'ltr:translate-x-0 rtl:translate-x-0': currentViewLevel !== 'third',
                                'ltr:-translate-x-full rtl:translate-x-full': currentViewLevel === 'third'
                            }"
                        >
                            <!-- First level view -->
                            <div class="h-[calc(100vh-74px)] w-full flex-shrink-0 overflow-auto">
                                <div class="py-4">
                                    <div
                                        v-for="category in categories"
                                        :key="category.id"
                                        :class="{'mb-2': category.children && category.children.length}"
                                    >
                                        <div class="flex cursor-pointer items-center justify-between px-6 py-2 transition-colors duration-200 hover:bg-gray-100">
                                            <a
                                                :href="category.url"
                                                class="text-base font-medium text-black"
                                            >
                                                @{{ category.name }}
                                            </a>
                                        </div>

                                        <!-- Second Level Categories -->
                                        <div v-if="category.children && category.children.length" >
                                            <div
                                                v-for="secondLevelCategory in category.children"
                                                :key="secondLevelCategory.id"
                                            >
                                                <div
                                                    class="flex cursor-pointer items-center justify-between px-6 py-2 transition-colors duration-200 hover:bg-gray-100"
                                                    @click="showThirdLevel(secondLevelCategory, category, $event)"
                                                >
                                                    <a
                                                        :href="secondLevelCategory.url"
                                                        class="text-sm font-normal"
                                                    >
                                                        @{{ secondLevelCategory.name }}
                                                    </a>

                                                    <span
                                                        v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                                        class="icon-arrow-right rtl:icon-arrow-left"
                                                    ></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Third level view -->
                            <div
                                class="h-full w-full flex-shrink-0"
                                v-if="currentViewLevel === 'third'"
                            >
                                <div class="border-b border-gray-200 px-6 py-4">
                                    <button
                                        @click="goBackToMainView"
                                        class="flex items-center justify-center gap-2 focus:outline-none"
                                        aria-label="Go back"
                                    >
                                        <span class="icon-arrow-left rtl:icon-arrow-right text-lg"></span>

                                        <p class="text-base font-medium text-black">
                                            @lang('shop::app.components.layouts.header.desktop.bottom.back-button')
                                        </p>
                                    </button>
                                </div>

                                <!-- Third Level Content -->
                                <div class="py-4">
                                    <div
                                        v-for="thirdLevelCategory in currentSecondLevelCategory?.children"
                                        :key="thirdLevelCategory.id"
                                        class="mb-2"
                                    >
                                        <a
                                            :href="thirdLevelCategory.url"
                                            class="block px-6 py-2 text-sm transition-colors duration-200 hover:bg-gray-100"
                                        >
                                            @{{ thirdLevelCategory.name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-shop::drawer>
        </div>
    </script>

    <style type="text/css">
        @media (min-width: 1024px) {
          .lg\:flex {
            display: flex;
          }
          .lg\:hidden {
            display: none;
          }
        }
        @media (min-width: 1280px) {
          .xl\:flex {
            display: flex;
          }
        }

        /* Isolated Topbar Styles - tc- prefix for True Cloud */
        .tc-topbar-container {
            display: none;
            background-color: rgba(15, 23, 42, 0.95);
            color: rgb(226, 232, 240);
        }

        @media (min-width: 1024px) {
            .tc-topbar-container {
                display: block;
            }
        }

        .tc-topbar-wrapper {
            margin-left: auto;
            margin-right: auto;
            display: flex;
            max-width: 80rem;
            align-items: center;
            justify-content: space-between;
            padding-left: 1rem;
            padding-right: 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .tc-topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .tc-topbar-delivery {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tc-topbar-icon {
            opacity: 0.8;
        }

        .tc-topbar-guarantee {
            display: none;
        }

        @media (min-width: 768px) {
            .tc-topbar-guarantee {
                display: inline;
            }
        }

        .tc-topbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .tc-topbar-link {
            color: inherit;
            text-decoration: inherit;
        }

        .tc-topbar-link:hover {
            color: rgb(255, 255, 255);
        }

        .category:hover a.hover\:text-primary:hover {
            --tw-text-opacity: 1;
            color: rgb(255 107 53 / var(--tw-text-opacity, 1))
        }

        span.cursor-pointer:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(241 245 249 / var(--tw-bg-opacity, 1));
        }
        a:hover {
            --tw-text-opacity: 1;
            color: rgb(255 107 53 / var(--tw-text-opacity, 1));
        }
    </style>

    <script type="module">
        app.component('v-desktop-category', {
            template: '#v-desktop-category-template',

            data() {
                return {
                    isLoading: true,
                    categories: [],
                    isDrawerActive: false,
                    currentViewLevel: 'main',
                    currentSecondLevelCategory: null,
                    currentParentCategory: null
                }
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.isLoading = false;
                            this.categories = response.data.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                pairCategoryChildren(category) {
                    if (! category.children) return [];

                    return category.children.reduce((result, value, index, array) => {
                        if (index % 2 === 0) {
                            result.push(array.slice(index, index + 2));
                        }
                        return result;
                    }, []);
                },

                toggleCategoryDrawer() {
                    this.isDrawerActive = !this.isDrawerActive;
                    if (this.isDrawerActive) {
                        this.currentViewLevel = 'main';
                    }
                },

                onDrawerToggle(event) {
                    this.isDrawerActive = event.isActive;
                },

                onDrawerClose(event) {
                    this.isDrawerActive = false;
                },

                showThirdLevel(secondLevelCategory, parentCategory, event) {
                    if (secondLevelCategory.children && secondLevelCategory.children.length) {
                        this.currentSecondLevelCategory = secondLevelCategory;
                        this.currentParentCategory = parentCategory;
                        this.currentViewLevel = 'third';

                        if (event) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                },

                goBackToMainView() {
                    this.currentViewLevel = 'main';
                }
            },
        });
    </script>
    <script>
        function changeLocale(localeCode) {
            let url = new URL(window.location.href);
            url.searchParams.set('locale', localeCode);
            window.location.href = url.href;
        }
    </script>
@endPushOnce
{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.after') !!}
