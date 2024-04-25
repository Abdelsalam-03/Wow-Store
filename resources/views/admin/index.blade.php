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
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (!$settings)
                <div class="alert alert-danger">
                    Aplication Settings Is Not Setted Yet. <a href="{{ route('admin.settings.create') }}" class="link-danger">Set Now</a>
                </div>
            @endif
            <div class="p-4 sm:p-8">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                    @if ($role == 'manager')
                        <div class="col">
                            <a href="{{route('manager.admins.index')}}" class="text-decoration-none text-dark">
                                <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-secondary admin-item">
                                    Admins - ({{ $totalAdmins }})
                                </div>
                            </a>
                        </div>
                    @endif
                    @if ($pendingOrders)
                        <div class="col">
                            <a href="{{ route('admin.orders') }}?status=pending" class="text-decoration-none text-dark">
                                <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-danger admin-item">
                                    Pending Orders - {{ $pendingOrders  }}
                                </div>
                            </a>    
                        </div>
                    @endif
                    @if ($lowStockProducts)
                        <div class="col">
                            <a href="{{route('admin.products.index')}}?order-by=stock" class="text-decoration-none text-dark">
                                <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-warning admin-item">
                                    Low Stock - ({{ $lowStockProducts }})
                                </div>
                            </a>
                        </div>
                    @endif
                    <div class="col">
                        
                        <a href="{{route('admin.categories.index')}}" class="text-decoration-none text-dark">
                            <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-info admin-item">
                                Categories - ({{ $totalCategories }})
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{route('admin.products.index')}}" class="text-decoration-none text-dark">
                            <div class="bg-white rounded p-4 shadow text-center border-3 border-top-0 border-bottom-0 border-primary admin-item">
                                Products - ({{ $totalProducts }})
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-4 py-0 sm:p-8">
                <div class="row g-4">
                    @if ($pendingOrders || $processingOrders || $shippedOrders || $deliveredOrders)
                        @php
                            $totalOrders = $pendingOrders + $processingOrders + $shippedOrders + $deliveredOrders;
                        @endphp
                    
                        <div class="col col-12 col-md-6">
                            <div class="bg-white rounded p-4 shadow d-flex flex-column gap-2">
                                <h4 >Orders</h4>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($pendingOrders / $totalOrders) * 100 }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ ($processingOrders / $totalOrders) * 100 }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($shippedOrders / $totalOrders) * 100 }}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($deliveredOrders / $totalOrders) * 100 }}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="position-relative ms-2 ps-3">
                                    Pending
                                    <span class="position-absolute top-0 start-0 translate-middle-x p-2 bg-warning border border-light rounded-circle">
                                    </span>
                                </p>
                                <p class="position-relative ms-2 ps-3">
                                    Processing
                                    <span class="position-absolute top-0 start-0 translate-middle-x p-2 bg-info border border-light rounded-circle">
                                    </span>
                                </p>
                                <p class="position-relative ms-2 ps-3">
                                    Shipped
                                    <span class="position-absolute top-0 start-0 translate-middle-x p-2 bg-success border border-light rounded-circle">
                                    </span>
                                </p>
                                <p class="position-relative ms-2 ps-3">
                                    Delivered
                                    <span class="position-absolute top-0 start-0 translate-middle-x p-2 bg-primary border border-light rounded-circle">
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endif
                    <div class="col col-12 col-md-6">
                        <div class="bg-white rounded p-4 shadow d-flex flex-column gap-2">
                            <div class="d-flex flex-row">
                                <div class="content flex-1">
                                    <h4 class="text-nowrap">Total Sales</h4>
                                    <h2 class="text-nowrap text-primary">{{ $totalSales?$totalSales:'0' }}</h2>
                                </div>
                                <div class="image">
                                    <img src="{{asset('images/total.svg')}}" alt="Total Image" style="width: 300px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
