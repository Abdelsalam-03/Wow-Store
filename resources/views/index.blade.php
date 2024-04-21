<x-app-layout>
    <x-slot name="header">
        <form action="" method="GET">
            <input type="text" name="query" id="" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="removeLiveSearchContent()">
            <input type="submit" value="Search">
        </form>
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  {{-- <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5> --}}
                  <input type="text" name="query" id="live-search-input" class="form-control">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="live-search-results"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Understood</button>
                </div>
              </div>
            </div>
          </div>
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
            
            <div class="p-4 bg-white rounded shadow d-flex flex-column gap-3">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                    @foreach ($products as $product)
                        <x-product :product="$product" />
                    @endforeach
                </div>
                @if ($products->hasPages())
                    <hr>
                    <div>
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
    <script>
        cart();
        liveSearchListener();
    </script>
</x-app-layout>