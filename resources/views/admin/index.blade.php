<x-app-layout>
    @if(session('success'))
    <script>
        viewAlert('success', "{{ session('success') }}");
    </script>
    @endif
    @if(session('fail'))
    <script>
        viewAlert('danger', "{{ session('fail') }}")
    </script>
    @endif
    <x-slot name="orders">
        <x-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders')">
            Orders
        </x-nav-link>
    </x-slot>
    <x-slot name="ordersResponsive">
        <x-responsive-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders')">
            Orders
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="categories">
        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories')">
            Categories
        </x-nav-link>
    </x-slot>
    <x-slot name="categoriesResponsive">
        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories')">
            Categories
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="products">
        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products')">
            products
        </x-nav-link>
    </x-slot>
    <x-slot name="productsResponsive">
        <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products')">
            Products
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                </div>
            </div> --}}

            <div class="p-4 sm:p-8">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                    <div class="col">
                        @php
                            $pendingTotal = count($pendingOrders);
                        @endphp
                        @if ($pendingTotal)
                            <a href="{{ route('admin.orders') }}?status=pending" class="text-decoration-none text-dark">
                                <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-danger admin-item">
                                    Pending Orders - {{ $pendingTotal  }}
                                </div>
                            </a>    
                        @else
                            <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-danger admin-item">
                                Pending Orders
                            </div>

                        @endif
                    </div>
                    <div class="col">
                        
                        <a href="{{route('admin.categories.index')}}" class="text-decoration-none text-dark">
                            <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-warning admin-item">
                                Categories
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{route('admin.products.index')}}" class="text-decoration-none text-dark">
                            <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-primary admin-item">
                                Products
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-info admin-item">
                            Sold
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
