<x-app-layout class="form-control">
    <x-slot name="header">
        <form action="" method="GET">
            <div class="input-group">
                <input type="text" name="query" data-bs-toggle="modal" class="form-control" data-bs-target="#staticBackdrop" onclick="prepareForSearch()" value="{{ isset($_GET['query']) ? $_GET['query'] : '' }}">
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </form>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                <div class="modal-header gap-2">
                    <form action="" method="GET" class="w-100">
                        <div class="input-group">
                            <input type="text" name="query" id="live-search-input" class="form-control btn-primary" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            <input type="submit" class="btn btn-primary" id="inputGroup-sizing-sm" value="Search">
                        </div>
                    </form>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="live-search-results"></div>
                </div>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 bg-white rounded shadow d-flex flex-column gap-3">
                <form action="" class="d-flex flex-column justify-content-center gap-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center align-items-center">
                        <div class="col d-flex justify-content-center align-items-center gap-2">
                            <label for="order-by" style="white-space: nowrap">Order By</label>
                            <select class="form-select" id="order-by" aria-label="Default select example" name="order-by">
                                <option value="0" selected>None</option>
                                <option value="name">Name</option>
                                <option value="price">Price</option>
                            </select>
                        </div>
                        <div class="col d-flex justify-content-center align-items-center gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="order" id="order-asc" checked value="asc">
                                <label class="form-check-label" for="order-asc">
                                  Ascending
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="order" id="order-desc" @checked(isset($_GET['order']) && $_GET['order'] == "desc") value="desc">
                                <label class="form-check-label" for="order-desc">
                                  Descending
                                </label>
                              </div>
                        </div>
                        <div class="col d-flex justify-content-center align-items-center gap-2">
                            <div class="d-flex flex-column gap-1 justify-content-center text-center">
                                <label for="min">Min Price</label>
                                <input type="number" name="min-price" id="min" class="form-control" value="{{ isset($_REQUEST['min-price']) ? $_REQUEST['min-price'] : '' }}">
                            </div>
                            <div class="d-flex flex-column gap-1 justify-content-center text-center">
                                <label for="max">Max Price</label>
                                <input type="number" name="max-price" id="max" class="form-control" value="{{ isset($_REQUEST['max-price']) ? $_REQUEST['max-price'] : '' }}">
                            </div>
                        </div>
                    </div>
                    @isset($_REQUEST['query'])
                        <input type="hidden" name="query" value="{{ $_REQUEST['query'] }}">
                    @endisset
                    <input type="submit" value="Filter" class="btn btn-outline-primary align-self-center">
                </form>
            </div>
            
        </div>
    </div>
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