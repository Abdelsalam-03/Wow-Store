<div class="col mb-5">
    <div class="card h-100">
        <a href="{{ route('user.product', ['product' => $product->id]) }}">
        <!-- Product image-->
        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
        <!-- Product details-->
        </a>
        <div class="card-body p-4">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder">{{ $product->name }}</h5>
                <!-- Product price-->
                <span class="text-secondary">{{ $product->price }}</span>
            </div>
        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><button class="btn btn-outline-dark mt-auto" onclick="addToCart({{$product->id}})">Add To Cart</button></div>
        </div>
    </div>
</div>