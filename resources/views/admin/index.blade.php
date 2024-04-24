<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    <a href="{{route('admin.products.index')}}">Products</a>
    <a href="{{route('admin.categories.index')}}">Categories</a>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                </div>
            </div>

            <div class="p-4 sm:p-8">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                    <div class="col">
                        @php
                            $pendingTotal = count($pendingOrders);
                        @endphp
                        @if ($pendingTotal)
                            <a href="{{ route('admin.orders') }}" class="text-decoration-none text-dark">
                                <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-info">
                                    Pending Orders - {{ $pendingTotal  }}
                                </div>
                            </a>    
                        @else
                            <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-info">
                                Pending Orders
                            </div>

                        @endif
                    </div>
                    <div class="col">
                        <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-warning">
                            Categories
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-primary">
                            Products
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-danger">
                            Sold
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
