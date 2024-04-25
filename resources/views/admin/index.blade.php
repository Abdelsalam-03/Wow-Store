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
    <x-slot name="adminLinks">
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (!$settings)
                <div class="alert alert-danger">
                    Aplication Settings Is Not Setted Yet. <a href="{{ route('admin.settings.create') }}" class="link-danger">Set Now</a>
                </div>
            @else
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                    @if ($role == 'manager')
                        <div class="col">
                            <a href="{{route('manager.admins.index')}}" class="text-decoration-none text-dark">
                                <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-secondary admin-item">
                                    Admins
                                </div>
                            </a>
                        </div>
                    @endif
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
                                Pending Orders - (0)
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
