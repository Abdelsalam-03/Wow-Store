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
        <x-nav-link :href="route('user.orders')" :active="request()->routeIs('user.orders')">
            My Orders
        </x-nav-link>
    </x-slot>
    <x-slot name="ordersResponsive">
        <x-responsive-nav-link :href="route('user.orders')" :active="request()->routeIs('user.orders')">
            My Orders
        </x-responsive-nav-link>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="d-flex justify-content-center px-4 py-4 @if (count($orders)) {{'d-none'}} @endif">
            <div class="card shadow" style="max-width: 600px">
                <img src="{{ asset('images/empty-cart.svg') }}" class="card-img" alt="No Orders Image">
                <div class="card-img-overlay">
                    <a href="{{ route('home') . '#products' }}" class="btn btn-lg btn-outline-dark">Make Orders Now !</a>
                </div>
            </div>
        </div>
        <div class="p-4 sm:p-8 @if (! count($orders)) {{'d-none'}} @endif">
            <div class="row g-4">
                <div class="col col-12">
                    <div class="p-4 bg-white rounded shadow d-flex flex-column">
                        <div class="head">
                            <h2 class="m-0">Orders List</h2>
                        </div>
                        <hr class="border-danger">
                        <div class="body">
                            @foreach ($orders as $order)
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
                                    {{ $order->total + $order->shipping_cost }}
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
                                <div class="col-12 mt-2 text-sm fw-bold">
                                    Shipping Cost - {{ $order->shipping_cost }}
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
                                @foreach ($orderProducts as $product)
                                    @if ($product->order_id == $order->id)
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-4 text-sm p-1">
                                            {{ $product->name }}
                                        </div>
                                        <div class="col-4 text-sm p-1">
                                            {{ $product->quantity }}
                                        </div>
                                        <div class="col-4 text-sm p-1">
                                            {{ $product->price }}
                                        </div>
                                        
                                    @endif
                                @endforeach
                                @if ($order->status != 'delivered' && $order->status != 'canceled')
                                    <div class="col-12"><hr class="border-primary"></div>
                                    <div class="col-12 text-end">
                                        <form action="{{ route('user.orders.delete', ['order' => $order->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <hr class="border-danger border-4">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        addEventToCartQuantity();
    </script>

</x-app-layout>