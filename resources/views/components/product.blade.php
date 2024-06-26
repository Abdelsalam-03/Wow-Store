<div class="col">
    <div class="card h-100 shadow">
        <a href="{{ route('user.product', ['product' => $product->id]) }}">
        <img class="card-img-top" src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('storage/' . $settings->default_products_photo)}}" alt="Product Image" />
        </a>
        <div class="card-body py-4 px-1">
            <div class="text-center">
                <h5 class="fw-bolder">{{ $product->name }}</h5>
                <span class="text-secondary">{{ $product->price }}</span>
            </div>
        </div>
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><button class="btn btn-outline-dark mt-auto" onclick="addToCart({{$product->id}})" @disabled($guest)>Add To Cart</button></div>
        </div>
    </div>
</div>