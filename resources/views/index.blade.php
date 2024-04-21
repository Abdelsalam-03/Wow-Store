<x-app-layout>
    <x-slot name="header">
        <form action="" method="GET">
            <input type="text" name="query" id="">
            <input type="submit" value="Search">
        </form>
    </x-slot>
<style>    
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

    <div class="bg-white">
        <div class="">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 overflow-auto d-flex gap-2 justify-content-center hide-scrollbar">
                @foreach ($categories as $category)
                <a href="{{ '/' . $category->id }}" style="white-space: nowrap;" class="btn btn-sm btn-secondary">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div style="display: none">
        <button onclick="destroyCart()">Empty Cart</button>
        <hr>
        <div class="cart" >
        </div>
        <hr>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 bg-white rounded shadow">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                    @foreach ($products as $product)
                        <x-product :product="$product" />
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
    <script>
        cart();
    </script>
</x-app-layout>