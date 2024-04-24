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
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orders
        </h2>
    </x-slot>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 p-4">
            <div class="row g-4">
                <div class="col col-12">
                    <div class="p-4 bg-white rounded shadow d-flex flex-column">
                        <div class="head">
                            <h2 class="m-0">Order Details - Order Id <span class="text-danger">{{ $order->id }}</span></h2>
                        </div>
                        <hr class="border-danger">
                        <div class="body">
                            <div class="row text-center">
                                <div class="date col-4 fw-bold">
                                    Date
                                </div>
                                <div class="total col-4 fw-bold">
                                    Total
                                </div>
                                <div class="status col-4 fw-bold">
                                    Status
                                </div>
                                <div class="col-12"><hr></div>
                                <div class="date col-4">
                                    {{ date('Y-m-d', $order->date) }}
                                </div>
                                <div class="price col-4">
                                    {{ $order->total }}
                                </div>
                                <div class="status col-4">
                                    <div class="d-flex flex-column">
                                        {{ $order->status }}
                                        <div class="progress">
                                            @if($order->status == 'pending')
                                                <div class="progress-bar bg-light w-100 text-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><i class="fas fa-ellipsis-h"></i></div>
                                            @elseif($order->status == 'processing')
                                                <div class="progress-bar bg-warning w-25" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            @elseif($order->status == 'shipped')
                                                <div class="progress-bar bg-primary w-75" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            @elseif($order->status == 'delivered')
                                                <div class="progress-bar bg-success w-100" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><i class="fa fa-check"></i></div>
                                            @elseif($order->status == 'canceled')
                                                <div class="progress-bar bg-danger w-100" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><i class="fa fa-cancel"></i></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><hr class="border-primary border-2"></div>
                                <div class="col-12 p-3 fw-bold">
                                    Address
                                </div>
                                <div class="col-12 text-sm">
                                    {{ $order->address }}
                                </div>
                                <div class="col-12"><hr class="border-primary border-2"></div>
                                <div class="col-12 p-3 fw-bold">
                                    Products
                                </div>
                                <div class="col-4 text-sm fw-bold">
                                    name
                                </div>
                                <div class="col-4 text-sm fw-bold">
                                    Quantity
                                </div>
                                <div class="col-4 text-sm fw-bold">
                                    Price
                                </div>
                                @php
                                    $accepted = true;
                                @endphp
                                @foreach ($orderProducts as $product)
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-4 text-sm p-1">
                                        {{ $product->name }}
                                    </div>
                                    <div class="col-4 text-sm p-1 d-flex flex-column position-relative">
                                        @if ($product->quantity > $product->stock && $order->status == 'pending')
                                            <i class="fa-solid fa-circle-xmark text-danger position-absolute top-0 translate-middle"></i>
                                            @php
                                                $accepted = false;
                                            @endphp
                                        @endif
                                        <div><strong>Quantity:</strong> {{ $product->quantity }}</div>
                                        <div><strong>In Stock:</strong> {{ $product->stock }}</div>
                                    </div>
                                    <div class="col-4 text-sm p-1 d-flex flex-column position-relative">
                                        @if ($product->price < $product->actual_price && $order->status == 'pending')
                                            <i class="fa-solid fa-circle-xmark text-danger position-absolute top-0 translate-middle"></i>
                                            @php
                                                $accepted = false;
                                            @endphp
                                        @endif
                                        <div><strong>Price:</strong> {{ $product->price }}</div>
                                        <div><strong>Actual Price:</strong> {{ $product->actual_price }}</div>
                                    </div>
                                @endforeach
                                <div class="col-12"><hr class="border-primary"></div>
                                    <div class="col-12 text-end d-flex justify-content-end gap-2">
                                        @if ($order->status == 'shipped')
                                            <form action="{{ route('admin.orders.arrive', ['order' => $order->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-success">Order Arrived</button>
                                            </form>
                                        @endif
                                        @if ($order->status == 'processing')
                                            <form action="{{ route('admin.orders.ship', ['order' => $order->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-warning">Ship Order</button>
                                            </form>
                                        @endif
                                        @if ($accepted && $order->status == 'pending')
                                            <form action="{{ route('admin.orders.process', ['order' => $order->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-success">Process Order</button>
                                            </form>
                                        @endif
                                        @if ($order->status == 'pending')
                                            <form action="{{ route('admin.orders.delete', ['order' => $order->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Cancel Order</button>
                                            </form>
                                        @endif
                                </div>
                            </div>
                            <hr class="border-danger border-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
