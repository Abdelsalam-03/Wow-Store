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
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                Create Product
            </h2>
        </div>
    </x-slot>
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center bg-white rounded shadow p-4">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{$product->photo ? asset('storage/' . $product->photo) : asset('storage/' . $settings->default_products_photo) }}" alt="..." /></div>
                <div class="col-md-6">
                    <div class="small mb-1">Category: {{ $product->category->name }}</div>
                    <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                    <div class="fs-6 mb-1">
                        <span>Price: {{ $product->price }}</span>
                    </div>
                    @if (count($product->onCart))
                        <div class="fs-6 mb-1 d-flex flex-column gap-2">
                            <p class="m-0">Appears Now On {{ count($product->onCart) }} Cart.</p>
                            @php
                                $quantityOnCarts = 0;
                                foreach ($product->onCart as $cartElement) {
                                    $quantityOnCarts += $cartElement->quantity;
                                }
                            @endphp
                            <p class="m-0">With Total Quantaty {{ $quantityOnCarts }}.</p>
                        </div>
                    @endif
                    <div class="fs-6 mb-1 {{ $product->stock <= 5 ? 'text-danger' : 'text-success' }}">
                        <span>Stock: {{ $product->stock }}</span>
                    </div>
                    <p class="fs-6">{{ isset($product->description) ? 'Description : ' . $product->description : "" }}</p>
                    <div class="d-flex flex-row gap-2">
                        <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>