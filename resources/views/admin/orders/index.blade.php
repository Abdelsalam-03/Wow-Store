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
            Orders
        </h2>
    </x-slot>
    {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 ">
            <div class="row g-4">
                <div class="col col-12">
                    <div class=" bg-white rounded shadow">
                        <div class="d-flex justify-content-center my-3">
                            <div class="p-4 rounded d-flex flex-column gap-4">
                                <form action="{{ route('admin.orders.search') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="id" class="form-control" required>
                                        <input type="submit" value="Search" class="btn btn-dark">
                                    </div>
                                </form>
                                <p class="text-center m-0">Filter Orders</p>
                                <form action="{{ route('admin.orders') }}" method="GET" class="order-status-form">
                                    <div class="d-flex gap-3 align-items-center">
                                        <select name="status" class="form-control">
                                            <option value="" selected>All</option>
                                            <option value="pending" @selected(isset($_GET['status']) && $_GET['status'] == 'pending')>Pending</option>
                                            <option value="processing" @selected(isset($_GET['status']) && $_GET['status'] == 'processing')>Processing</option>
                                            <option value="shipped" @selected(isset($_GET['status']) && $_GET['status'] == 'shipped')>Shipped</option>
                                            <option value="delivered" @selected(isset($_GET['status']) && $_GET['status'] == 'delivered')>Delivered</option>
                                            <option value="canceled" @selected(isset($_GET['status']) && $_GET['status'] == 'canceled')>Canceled</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 ">
                <div class="row bg-white rounded shadow gap-2 my-4">
                    <div class="col col-12">
                        <div class="d-flex justify-content-center pt-2">
                            <div class="p-4 rounded d-flex flex-column gap-4">
                                <form action="{{ route('admin.orders.search') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="id" class="form-control" required>
                                        <input type="submit" value="Search" class="btn btn-dark">
                                    </div>
                                </form>
                                <p class="text-center m-0">Filter Orders</p>
                                <form action="{{ route('admin.orders') }}" method="GET" class="order-status-form">
                                    <div class="d-flex gap-3 align-items-center">
                                        <select name="status" class="form-control">
                                            <option value="" selected>All</option>
                                            <option value="pending" @selected(isset($_GET['status']) && $_GET['status'] == 'pending')>Pending</option>
                                            <option value="processing" @selected(isset($_GET['status']) && $_GET['status'] == 'processing')>Processing</option>
                                            <option value="shipped" @selected(isset($_GET['status']) && $_GET['status'] == 'shipped')>Shipped</option>
                                            <option value="delivered" @selected(isset($_GET['status']) && $_GET['status'] == 'delivered')>Delivered</option>
                                            <option value="canceled" @selected(isset($_GET['status']) && $_GET['status'] == 'canceled')>Canceled</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (count($orders)) 
                        <div class="col col-12"><hr></div>
                        <div class="col col-12">
                            <div class="p-4 d-flex flex-column">
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
                                        <div class="col-12 mt-2 text-sm fw-bold">
                                            Shipping Cost - {{ $order->shipping_cost }}
                                        </div>
                                        <div class="col-12"><hr class="border-primary"></div>
                                        <div class="col-12 text-end d-flex justify-content-end gap-3">
                                            <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="btn btn-outline-primary">Show Order</a>
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
                                    @endforeach
                                </div>
                                @if ($orders->hasPages())
                                    <hr>
                                    <div>
                                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="col col-12"><hr></div>
                        <h2 class="text-center text-danger p-2">There Is No Orders To Show.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        addAutoSubmitToFilteringOrders();
    </script>
</x-app-layout>
