<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <form action="" method="GET">
        <input type="text" name="query" id="">
        <input type="submit" value="Search">
    </form>
    <hr>
    <button onclick="destroyCart()">Empty Cart</button>
    <hr>
    <div class="cart"></div>
    <hr>
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 justify-content-center">
        @foreach ($products as $product)
            <x-product :product="$product" />
        @endforeach
        </div>
    </div>
    <script>
        cart();
    </script>
</x-app-layout>