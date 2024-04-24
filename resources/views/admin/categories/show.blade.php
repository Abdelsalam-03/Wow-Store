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
        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
            Categories
        </x-nav-link>
    </x-slot>
    <x-slot name="categoriesResponsive">
        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
            Categories
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="products">
        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
            products
        </x-nav-link>
    </x-slot>
    <x-slot name="productsResponsive">
        <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
            Products
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                {{ $category->name }}
            </h2>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                @if (count($products))
                    <h3 class="text-center">Related Products</h3>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 justify-content-center gy-4">
                        @foreach ($products as $product)
                            <x-admin-product :product="$product"/>
                        @endforeach
                    </div>
                    @if ($products->hasPages())
                        <hr>
                        <div>
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <h3 class="text-center text-danger">No Products Here.</h3>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>
