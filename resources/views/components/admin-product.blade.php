<div class="col">
    <div class="card h-100 shadow position-relative">
        @if($product->stock == 0)
            <span class="position-absolute top-0 start-50 translate-middle p-2 badge rounded-pill bg-danger">
                Out Of Stock
            </span>
        @elseif($product->stock <= 5)
            <span class="position-absolute top-0 start-50 translate-middle p-2 badge rounded-pill bg-warning text-dark">
                Low Stock
            </span>
        @endif
        <a href="{{ route('user.product', ['product' => $product->id]) }}">
        <img class="card-img-top" src="{{$product->photo? asset('storage/' . $product->photo) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'}}" alt="..." />
        </a>
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="fw-bolder">{{ $product->name }}</h5>
                <p class="">Price - {{ $product->price }}</p>
                <p class="">Stock - {{ $product->stock }}</p>
            </div>
        </div>
        <hr class="mt-0">
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.products.show', ['product' => $product->id]) }}" class="btn btn-sm btn-outline-primary">Show</a>
                <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            </div>
        </div>
    </div>
</div>