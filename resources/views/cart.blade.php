<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @php
            $totalPrice = 0;   
            $totalItems = 0;
            $totalProducts = count($content);
        @endphp
        <div class="d-flex justify-content-center px-4 @if ($totalProducts) {{'d-none'}} @endif">
            <div class="card shadow" style="max-width: 600px">
                <img src="{{ asset('images/empty-cart.svg') }}" class="card-img" alt="Empty Cart Image">
                <div class="card-img-overlay">
                    <h5 class="card-title">Your Cart is empty.</h5>
                </div>
            </div>
        </div>
        <div class="p-4 sm:p-8 @if (! $totalProducts) {{'d-none'}} @endif">
            <div class="row g-4">
                <div class="col col-12 col-md-9">
                    <div class="p-4 bg-white rounded shadow d-flex flex-column">
                        <div class="head d-flex flex-row justify-between align-items-center">
                            <h2 class="m-0">Shopping Cart</h2>
                            <form action="{{ route('cart.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <hr>
                        <div class="body">
                            @foreach ($content as $product)
                            <div class="row">
                                <div class="photo col-3">
                                    <a href="{{ route('user.product', ['product' => $product->product_id]) }}">
                                        <img src="{{ asset('storage/' . $product->photo) }}" class="rounded" alt="Product Image">
                                    </a>
                                </div>
                                <div class="content col-6 d-flex flex-column justify-content-between gap-2">
                                    <h5>{{ $product->name }}</h5>
                                    <div class="actions d-flex gap-2 align-items-center text-sm">
                                        <label for="quantity">Qty</label>
                                        <form action="{{ route('cart.update', ['product' => $product->product_id]) }}" class="w-25 cart-quantity" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" class="form-control form-control-sm quantity" id="" value="{{ $product->quantity }}">
                                        </form>
                                        <form action="{{ route('cart.remove', ['product' => $product->product_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="link-danger" value="Remove">
                                        </form>
                                    </div>
                                </div>
                                <div class="price col-3">
                                    <h5 class="text-end text-bold">{{ $product->price }}</h5>
                                </div>
                            </div>
                                <hr>
                                @php
                                    $totalPrice+= $product->price;
                                    $totalItems+= $product->quantity;
                                @endphp
                            @endforeach
                        </div>
                        <div class="foot">
                            <div class="d-flex align-items-center justify-content-end text-sm">
                                <span class="d-inline-block text-secondary">Total ({{ $totalItems }}) : </span>&nbsp;<h5 class="text-bold d-inline-block m-0"> {{ $totalPrice }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-md-3">
                    <div class="bg-white rounded p-4 shadow d-flex flex-column gap-4 justify-content-center">
                        <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
                        <a href="{{ route('home') . '#products' }}" class="btn btn-outline-dark">Shop More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        addEventToCartQuantity();
    </script>

</x-app-layout>