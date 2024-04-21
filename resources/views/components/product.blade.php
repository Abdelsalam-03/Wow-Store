<div class="col">
    <div class="card h-100 shadow">
        <a href="{{ route('user.product', ['product' => $product->id]) }}">
        <img class="card-img-top" src="{{$product->photo? asset('storage/' . $product->photo) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'}}" alt="..." />
        </a>
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="fw-bolder">{{ $product->name }}</h5>
                <span class="text-secondary">{{ $product->price }}</span>
            </div>
        </div>
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><button class="btn btn-outline-dark mt-auto" onclick="addToCart({{$product->id}})">Add To Cart</button></div>
        </div>
    </div>
</div>