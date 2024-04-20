<x-app-layout>
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{$product->photo ? asset('storage/' . $product->photo) : 'https://dummyimage.com/600x700/dee2e6/6c757d.jpg'}}" alt="..." /></div>
                <div class="col-md-6">
                    <div class="small mb-1">Category: {{ $product->category->name }}</div>
                    <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                    <div class="fs-5 mb-5">
                        <span class="text-decoration-line-through text-secondary">{{ $product->price + floor($product->price / 10) }}</span>
                        <span>{{ $product->price }}</span>
                    </div>
                    <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?</p>
                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                        @csrf
                        <input class="form-control text-center me-3 rounded" name="quantity" id="inputQuantity" value="1" style="max-width: 5rem" />
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <input type="hidden" name="toHome" value="1">
                        <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>