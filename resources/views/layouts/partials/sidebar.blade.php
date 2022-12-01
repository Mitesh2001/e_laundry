
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid" style="min-height:0">

        <!-- Brand -->
        <a class="navbar-brand " href="{{ route('root') }}">
            <img src="{{asset('web/logos/Logo.svg')}}" class="navbar-brand-img" alt="Admin Logo">
        </a>
        <!-- Collapse -->
        <div>
            {{-- Main Admin --}}
            <ul class="navbar-nav">


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('root') ? 'active':'' }}" href="{{ route('root') }}">
                        <i class="fa fa-desktop text-teal"></i>
                        <span class="nav-link-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.index') ? 'active':'' }}" href="{{ route('customer.index') }}">
                        <i class="fa fa-users text-red"></i>
                        <span class="nav-link-text">{{ __('Customer') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('service.*') ? 'active':'' }}" href="{{route('service.index')}}" href="{{ route('service.index') }}">
                        <i class="fas fa-cogs text-pink"></i>
                        <span class="nav-link-text">{{ __('Services') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('variant.*') ? 'active':'' }}" href="{{route('variant.index')}}">
                        <i class="fas fa-list text-pink"></i>
                        <span class="nav-link-text">{{ __('Variants') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('product.*') ? 'active':'' }}" href="{{ route('product.index') }}">
                        <i class="fas fa-tshirt text-purple"></i>
                        <span class="nav-link-text">{{ __('Products') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('coupon.*') ? 'active':'' }}" href="{{ route('coupon.index') }}">
                        <i class="fa fa-percentage text-purple"></i>
                        <span class="nav-link-text">{{ __('Coupon') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('order.*') ? 'active':'' }}" href="{{ route('order.index') }}">
                        <i class="fa fa-shopping-cart text-orange"></i>
                        <span class="nav-link-text">{{ __('Orders') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('revenue.*') ? 'active':'' }}"
                        href="{{ route('revenue.index', ['from' => now()->subMonth(1)->format('Y-m-d'), 'to' => now()->addDay(1)->format('Y-m-d')]) }}">
                        <i class="fa fa-file text-red"></i>
                        <span class="nav-link-text">{{__('Reports')}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    {{-- <a class="nav-link  {{ request()->routeIs('banner.*') ? 'active':'' }}" href="{{route('banner.promotional')}}" >
                        <i class="fas fa-image text-dark"></i>
                        <span class="nav-link-text">{{__('App Banners')}}</span>
                    </a> --}}

                    <a class="nav-link  {{ request()->routeIs('banner.*') ? 'active':'' }}" href="#banner"  data-toggle="collapse"  aria-expanded="false" role="button" aria-controls="navbar-examples">
                        <i class="fas fa-image text-dark"></i>
                        <span class="nav-link-text">{{__('App Banners')}}</span>
                    </a>

                    <div class="collapse {{ request()->routeIs('banner.*') ? 'show':'' }}" id="banner">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('banner.index')}}">Web Banners</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('banner.promotional')}}">Mobile Banners</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ request()->routeIs('setting.*') ? 'active':'' }}" href="#setting" data-toggle="collapse"  aria-expanded="false" role="button" aria-controls="navbar-examples">
                        <i class="fa fa-cog text-red"></i>
                        <span class="nav-link-text">{{__('Settings')}}</span>
                    </a>

                    <div class="collapse {{ request()->routeIs('setting.*') ? 'show':'' }}" id="setting">
                        <ul class="nav nav-sm flex-column">
                            @foreach (config('enums.settings') as $index => $item)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('setting.show', $index) }}">{{ $item }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" onclick="event.preventDefault();
                                        document.getElementById('logout').submit()" href="#">
                        <i class="fas fa-sign-out-alt text-warning"></i>
                        <span class="nav-link-text">{{ __('Logout') }}</span>
                    </a>
                    <form id="logout" action="{{ route('logout') }}" method="POST"> @csrf </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
