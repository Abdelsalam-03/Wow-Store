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
    <x-slot name="links">
        <div class="d-flex align-items-center flex-fill justify-content-end mx-2">
            <x-cart-button />
        </div>
    </x-slot>
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
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center bg-white p-4 rounded shadow">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('storage/' . $settings->default_products_photo) }}" alt="Product Image" /></div>
                <div class="col-md-6">
                    <div class="small mb-1"><a href="/?category={{ $product->category_id }}#products" class="link-secondary">Category: {{ $product->category->name }}</a></div>
                    <h1 class="display-5 fw-bolder text-primary">{{ $product->name }}</h1>
                    <div class="fs-6 mb-4 fw-bold">
                        {{-- <span class="text-decoration-line-through text-secondary">{{ $product->price + floor($product->price / 10) }}</span> --}}
                        <span>Price: {{ $product->price }}</span>
                    </div>
                    <p class="lead text-secondary fs-6">{{ isset($product->description) ? $product->description : "" }}</p>
                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                        @csrf
                        <input type="hidden" name="productId" value="{{ $product->id }}">
                        <input type="hidden" name="return-to-home" value="1">
                        @auth
                            <input class="form-control text-center me-3 rounded" name="quantity" id="inputQuantity" value="1" style="max-width: 5rem" />
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        @else
                            <input class="form-control text-center me-3 rounded" name="quantity" disabled id="inputQuantity" value="1" style="max-width: 5rem" />
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit" disabled>
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </section>
    

    @if (count($relatedProducts) > 1)
        <section class="py-3 bg-white">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($relatedProducts as $relatedProduct)
                        @if ($relatedProduct->id != $product->id)
                            <div class="col mb-5">
                                <x-product :product="$relatedProduct" :settings="$settings" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <script>
        cart();
    </script>
</x-app-layout>