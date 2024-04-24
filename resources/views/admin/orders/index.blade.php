<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orders
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                </div>
            </div>
            <div class="p-4 sm:p-8 @if (! count($orders)) {{'d-none'}} @endif">
                <div class="row g-4">
                    <div class="col col-12">
                        <div class="p-4 bg-white rounded shadow d-flex flex-column">
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
                                    <div class="col-12"><hr class="border-primary"></div>
                                    <div class="col-12 text-end d-flex justify-content-end gap-3">
                                        <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="btn btn-primary">Show Order</a>
                                        @if ($order->status == 'pending')
                                            <form action="{{ route('user.orders.delete', ['order' => $order->id]) }}" method="POST">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
