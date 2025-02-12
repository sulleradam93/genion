<nav x-data="{ open: false }" class="dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                @php
                    $user = Auth::user();
                @endphp

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    {{-- Admin és Manager menüpontok --}}
                    @if ($user->hasRole('admin') || $user->hasRole('manager'))
                    <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.index')">
                        {{ __('navigation.students') }}
                    </x-nav-link>

                    <x-nav-link :href="route('job_positions.index')" :active="request()->routeIs('job_positions.index')">
                        {{ __('navigation.job_positions') }}
                    </x-nav-link>

                    <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                        {{ __('navigation.companies') }}
                    </x-nav-link>

                    <x-nav-link :href="route('company_jobs.index')" :active="request()->routeIs('company_jobs.index')">
                        {{ __('navigation.positions') }}
                    </x-nav-link>

                    <x-nav-link :href="route('work_records.index')" :active="request()->routeIs('work_records.index')">
                        {{ __('navigation.work_records') }}
                    </x-nav-link>

                    <x-nav-link :href="route('company_payments.index')" :active="request()->routeIs('company_payments.index')">
                        {{ __('navigation.company_payments') }}
                    </x-nav-link>

                    <x-nav-link :href="route('student_payments.index')" :active="request()->routeIs('student_payments.index')">
                        {{ __('navigation.student_payments') }}
                    </x-nav-link>
                    @endif

                    @if ($user->hasRole('admin'))
                    <x-nav-link :href="route('managers.index')" :active="request()->routeIs('managers.index')">
                        {{ __('navigation.managers') }}
                    </x-nav-link>
                    @endif


                    @if ($user->hasRole('student'))
                        <x-nav-link :href="route('company_payments.current_company_payments')" :active="request()->routeIs('company_payments.current_company_payments')">
                            {{ __('navigation.my_payments_student') }}
                        </x-nav-link>
                    @endif

                    @if ($user->hasRole('company'))
                        <x-nav-link :href="route('student_payments.current_student_payments')" :active="request()->routeIs('student_payments.current_student_payments')">
                            {{ __('navigation.my_payments_company') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>
            
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="32">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('navigation.profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('navigation.logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                
                <x-dropdown align="right" width="24">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            @php($languages = ["en" => "English", "hu" => "Magyar"])
                            
                            <!-- Nyelvi zászló megjelenítése az aktuális nyelv alapján -->
                            @if (App::getLocale() == 'hu')
                                <svg class="w-4 h-4" viewBox="0 0 640 480">
                                    <g fill-rule="evenodd" stroke-width="1pt">
                                        <path fill="#ffffff" d="M0 0h640v480H0z"/>
                                        <path fill="#d43516" d="M0 0h640v160H0z"/>
                                        <path fill="#388d00" d="M0 320h640v160H0z"/>
                                    </g>
                                </svg>
                            @else
                                <svg class="w-4 h-4" viewBox="0 0 640 480">
                                    <g fill-rule="evenodd" stroke-width="1pt">
                                        <path fill="#012169" d="M0 0h640v480H0z"/>
                                        <path fill="#ffffff" d="M75 0l250 185L575 0h65v40L410 240l230 200v40h-65L325 295 75 480H0v-40l230-200L0 40V0h75z"/>
                                        <path fill="#c8102e" d="M424 281l216 167v32L362 281H424zM240 281L0 480v-32l186-145h54zM640 0v3L398 192h-67L640 10V0h60zM0 0h66l216 167H240L0 40V0z"/>
                                        <path fill="#ffffff" d="M240 0v480h160V0H240zM0 160v160h640V160H0z"/>
                                        <path fill="#c8102e" d="M280 0v480h80V0h-80zM0 200v80h640v-80H0z"/>
                                    </g>
                                </svg>
                            @endif
                            
                            <!-- Dropdown ikon mellette -->
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('lang.change', ['lang' => 'hu'])" class="flex items-center space-x-2">
                            <svg class="w-4 h-4" viewBox="0 0 640 480">
                                <g fill-rule="evenodd" stroke-width="1pt">
                                    <path fill="#ffffff" d="M0 0h640v480H0z"/>
                                    <path fill="#d43516" d="M0 0h640v160H0z"/>
                                    <path fill="#388d00" d="M0 320h640v160H0z"/>
                                </g>
                            </svg>
                            <span>Magyar</span>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('lang.change', ['lang' => 'en'])" class="flex items-center space-x-2">
                            <svg class="w-4 h-4" viewBox="0 0 640 480">
                                <g fill-rule="evenodd" stroke-width="1pt">
                                    <path fill="#012169" d="M0 0h640v480H0z"/>
                                    <path fill="#ffffff" d="M75 0l250 185L575 0h65v40L410 240l230 200v40h-65L325 295 75 480H0v-40l230-200L0 40V0h75z"/>
                                    <path fill="#c8102e" d="M424 281l216 167v32L362 281H424zM240 281L0 480v-32l186-145h54zM640 0v3L398 192h-67L640 10V0h60zM0 0h66l216 167H240L0 40V0z"/>
                                    <path fill="#ffffff" d="M240 0v480h160V0H240zM0 160v160h640V160H0z"/>
                                    <path fill="#c8102e" d="M280 0v480h80V0h-80zM0 200v80h640v-80H0z"/>
                                </g>
                            </svg>
                            <span>English</span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Mobilra is megjelenítjük a fő menüpontokat -->
        <div class="pt-2 pb-3 space-y-1">
            @if ($user->hasRole('admin') || $user->hasRole('manager'))
            <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.index')">
                {{ __('navigation.students') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('job_positions.index')" :active="request()->routeIs('job_positions.index')">
                {{ __('navigation.job_positions') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.index')">
                {{ __('navigation.companies') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('company_jobs.index')" :active="request()->routeIs('company_jobs.index')">
                {{ __('navigation.positions') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('work_records.index')" :active="request()->routeIs('work_records.index')">
                {{ __('navigation.work_records') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('company_payments.index')" :active="request()->routeIs('company_payments.index')">
                {{ __('navigation.company_payments') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('student_payments.index')" :active="request()->routeIs('student_payments.index')">
                {{ __('navigation.student_payments') }}
            </x-responsive-nav-link>
            @endif

            @if ($user->hasRole('admin'))
            <x-responsive-nav-link :href="route('managers.index')" :active="request()->routeIs('managers.index')">
                {{ __('navigation.managers') }}
            </x-responsive-nav-link>
            @endif

            @if ($user->hasRole('student'))
            <x-responsive-nav-link :href="route('company_payments.current_company_payments')" :active="request()->routeIs('company_payments.current_company_payments')">
                {{ __('navigation.my_payments_student') }}
            </x-responsive-nav-link>
            @endif

            @if ($user->hasRole('company'))
            <x-responsive-nav-link :href="route('student_payments.current_student_payments')" :active="request()->routeIs('student_payments.current_student_payments')">
                {{ __('navigation.my_payments_company') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('navigation.profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('navigation.logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>
