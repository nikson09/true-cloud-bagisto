@props([
    'hasHeader'  => true,
    'hasFeature' => true,
    'hasFooter'  => true,
])

<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>

        {!! view_render_event('bagisto.shop.layout.head.before') !!}

        <title>{{ $title ?? '' }}</title>

        <meta charset="UTF-8">

        <meta
            http-equiv="X-UA-Compatible"
            content="IE=edge"
        >
        <meta
            http-equiv="content-language"
            content="{{ app()->getLocale() }}"
        >

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >
        <meta
            name="base-url"
            content="{{ url()->to('/') }}"
        >
        <meta
            name="currency"
            content="{{ core()->getCurrentCurrency()->toJson() }}"
        >

        @stack('meta')

        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="/favicon.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="/favicon.png"
        />
        <link
            rel="shortcut icon"
            href="/favicon.png"
        />
        <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="/favicon.png"
        />

        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

        <link
            rel="preload"
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            as="style"
        >
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        >

        <link
            rel="preload"
            href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
            as="style"
        >
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"
        >

        @stack('styles')

        <style>
            {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        </style>
        
        <style>
            /* True Cloud Loader Styles */
            .tc-loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.85);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                opacity: 1;
                transition: opacity 0.5s ease-out;
            }
            
            .tc-loader.hidden {
                opacity: 0;
                pointer-events: none;
            }
            
            .tc-loader-content {
                text-align: center;
                color: white;
            }
            
            .tc-cloud-loader {
                position: relative;
                width: 120px;
                height: 60px;
                margin: 0 auto 30px;
            }
            
            .tc-cloud {
                position: absolute;
                width: 60px;
                height: 30px;
                background: rgba(255, 255, 255, 0.95);
                border-radius: 30px;
                animation: float 3s ease-in-out infinite;
                box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
            }
            
            .tc-cloud:before {
                content: '';
                position: absolute;
                width: 30px;
                height: 30px;
                background: rgba(255, 255, 255, 0.95);
                border-radius: 50%;
                top: -15px;
                left: 10px;
                box-shadow: 0 2px 10px rgba(255, 255, 255, 0.3);
            }
            
            .tc-cloud:after {
                content: '';
                position: absolute;
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.95);
                border-radius: 50%;
                top: -20px;
                right: 10px;
                box-shadow: 0 3px 12px rgba(255, 255, 255, 0.3);
            }
            
            .tc-cloud-1 {
                left: 0;
                animation-delay: 0s;
            }
            
            .tc-cloud-2 {
                left: 30px;
                animation-delay: 0.5s;
            }
            
            .tc-cloud-3 {
                left: 60px;
                animation-delay: 1s;
            }
            
            .tc-dots {
                display: flex;
                justify-content: center;
                gap: 8px;
                margin-top: 20px;
            }
            
            .tc-dot {
                width: 12px;
                height: 12px;
                background: rgba(255, 255, 255, 0.95);
                border-radius: 50%;
                animation: pulse 1.5s ease-in-out infinite;
                box-shadow: 0 2px 8px rgba(255, 255, 255, 0.4);
            }
            
            .tc-dot:nth-child(1) { animation-delay: 0s; }
            .tc-dot:nth-child(2) { animation-delay: 0.2s; }
            .tc-dot:nth-child(3) { animation-delay: 0.4s; }
            
            .tc-loader-text {
                font-family: 'Poppins', sans-serif;
                font-size: 18px;
                font-weight: 600;
                margin-top: 20px;
                text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
                color: rgba(255, 255, 255, 0.95);
            }
            
            .tc-loader-subtext {
                font-family: 'Poppins', sans-serif;
                font-size: 14px;
                font-weight: 400;
                margin-top: 8px;
                opacity: 0.9;
                text-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
                color: rgba(255, 255, 255, 0.85);
            }
            
            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
            }
            
            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                    opacity: 0.7;
                }
                50% {
                    transform: scale(1.2);
                    opacity: 1;
                }
            }
            
            /* Responsive adjustments */
            @media (max-width: 768px) {
                .tc-cloud-loader {
                    width: 100px;
                    height: 50px;
                }
                
                .tc-cloud {
                    width: 50px;
                    height: 25px;
                }
                
                .tc-cloud:before {
                    width: 25px;
                    height: 25px;
                    top: -12px;
                    left: 8px;
                }
                
                .tc-cloud:after {
                    width: 35px;
                    height: 35px;
                    top: -17px;
                    right: 8px;
                }
                
                .tc-cloud-2 {
                    left: 25px;
                }
                
                .tc-cloud-3 {
                    left: 50px;
                }
                
                .tc-loader-text {
                    font-size: 16px;
                }
                
                .tc-loader-subtext {
                    font-size: 12px;
                }
            }
        </style>

        @if(core()->getConfigData('general.content.speculation_rules.enabled'))
            <script type="speculationrules">
                @json(core()->getSpeculationRules(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            </script>
        @endif

        {!! view_render_event('bagisto.shop.layout.head.after') !!}

    </head>

    <body>
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        <!-- True Cloud Loader -->
        <div id="tc-loader" class="tc-loader">
            <div class="tc-loader-content">
                <div class="tc-cloud-loader">
                    <div class="tc-cloud tc-cloud-1"></div>
                    <div class="tc-cloud tc-cloud-2"></div>
                    <div class="tc-cloud tc-cloud-3"></div>
                </div>
                <div class="tc-dots">
                    <div class="tc-dot"></div>
                    <div class="tc-dot"></div>
                    <div class="tc-dot"></div>
                </div>
                <div class="tc-loader-text">True Cloud</div>
                <div class="tc-loader-subtext">Завантаження...</div>
            </div>
        </div>

        <a
            href="#main"
            class="skip-to-main-content-link"
        >
            Skip to main content
        </a>

        <div id="app">
            <!-- Flash Message Blade Component -->
            <x-shop::flash-group />

            <!-- Confirm Modal Blade Component -->
            <x-shop::modal.confirm />

            <!-- Page Header Blade Component -->
            @if ($hasHeader)
                <x-shop::layouts.header />
            @endif

            @if(
                core()->getConfigData('general.gdpr.settings.enabled')
                && core()->getConfigData('general.gdpr.cookie.enabled')
            )
                <x-shop::layouts.cookie />
            @endif

            {!! view_render_event('bagisto.shop.layout.content.before') !!}

            <!-- Page Content Blade Component -->
            <main id="main" class="bg-white">
                {{ $slot }}
            </main>

            {!! view_render_event('bagisto.shop.layout.content.after') !!}


            <!-- Page Services Blade Component -->
            @if ($hasFeature)
                <x-shop::layouts.services />
            @endif

            <!-- Page Footer Blade Component -->
            @if ($hasFooter)
                <x-shop::layouts.footer />
            @endif
        </div>

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        @stack('scripts')

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.before') !!}
        <script>
            /**
             * Load event, the purpose of using the event is to mount the application
             * after all of our `Vue` components which is present in blade file have
             * been registered in the app. No matter what `app.mount()` should be
             * called in the last.
             */
            window.addEventListener("load", function (event) {
                app.mount("#app");
            });
        </script>

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.after') !!}

        <script type="text/javascript">
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script>
        
        <script type="text/javascript">
            // True Cloud Loader Management
            document.addEventListener('DOMContentLoaded', function() {
                const loader = document.getElementById('tc-loader');
                const app = document.getElementById('app');
                
                // Hide loader when page is fully loaded
                function hideLoader() {
                    if (loader) {
                        loader.classList.add('hidden');
                        // Remove loader from DOM after animation completes
                        setTimeout(() => {
                            if (loader.parentNode) {
                                loader.parentNode.removeChild(loader);
                            }
                        }, 500);
                    }
                }
                
                // Show loader for minimum time to ensure smooth experience
                const minLoadTime = 1500; // 1.5 seconds minimum
                const startTime = Date.now();
                
                function checkAndHideLoader() {
                    const elapsedTime = Date.now() - startTime;
                    const remainingTime = Math.max(0, minLoadTime - elapsedTime);
                    
                    setTimeout(hideLoader, remainingTime);
                }
                
                // Hide loader when window is fully loaded
                if (document.readyState === 'complete') {
                    checkAndHideLoader();
                } else {
                    window.addEventListener('load', checkAndHideLoader);
                }
                
                // Fallback: hide loader after maximum time (5 seconds)
                setTimeout(hideLoader, 5000);
                
                // Hide loader on navigation (for SPA-like behavior)
                document.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (link && link.href && !link.href.startsWith('#') && !link.target) {
                        // Show loader for navigation
                        if (loader && !loader.classList.contains('hidden')) {
                            // Keep loader visible during navigation
                            return;
                        }
                    }
                });
            });
        </script>
    </body>
</html>
