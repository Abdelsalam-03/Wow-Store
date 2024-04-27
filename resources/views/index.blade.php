<x-app-layout class="form-control">
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
    

    <div class="bg-white shadow">
        <div class="container">
            <div class="links d-flex flex-wrap gap-2 p-3 justify-content-center">
                <a href="{{ route('home') }}#products"class="btn btn-sm bg-gradient {{ isset($_GET['category'])? 'btn-dark' : 'btn-outline-dark'}}">All</a>
                @foreach ($categories as $category)
                    @if ($category->stock())
                        <a href="{{ '?category=' . $category->id }}#products" style="white-space: nowrap;" class="btn btn-sm bg-gradient {{ isset($_GET['category']) && $_GET['category'] == $category->id ?'btn-outline-dark': 'btn-dark'}}">{{ $category->name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div id="carouselExampleControls" class="carousel slide px-0 container-xxl" data-bs-ride="carousel">
        <div class="carousel-inner width-limit">
            @php
                $activated = false;
            @endphp
            @foreach ($categories as $category)
                @if ($category->photo && $category->stock())
                    <div class="carousel-item {{ !$activated ? 'active' : '' }}">
                        <a href="?category={{ $category->id }}#products" class="position-relative">
                            <img src="{{ asset('storage/' . $category->photo) }}" class="d-block w-100 mh-100" alt="Category Image">
                            <span class="d-block position-absolute start-0 top-0 p-4 bg-black w-100 h-100 opacity-50"></span>
                        </a>
                    </div>
                    @php
                        $activated = true;    
                    @endphp
                @endif
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>


    <div class="py-6 gradient-background">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <div class="p-4 rounded d-flex flex-column gap-4">
                <form action="/#products" method="GET" class="rounded shadow">
                    <div class="input-group">
                        <input type="text" name="query" data-bs-toggle="modal" class="form-control" data-bs-target="#staticBackdrop" onclick="prepareForSearch()" value="{{ isset($_GET['query']) ? $_GET['query'] : '' }}">
                        <input type="submit" value="Search" class="btn btn-primary">
                    </div>
                </form>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                        <div class="modal-header gap-2">
                            <form action="/#products" method="GET" class="w-100">
                                <div class="input-group">
                                    <input type="text" name="query" id="live-search-input" class="form-control btn-primary" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    <input type="submit" class="btn btn-primary" id="inputGroup-sizing-sm" value="Search">
                                </div>
                            </form>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="live-search-results" class="d-flex flex-column"></div>
                        </div>
                        </div>
                    </div>
                </div>
                <form action="/#products" class="d-flex flex-column justify-content-center gap-4 bg-white shadow rounded p-4 pb-5 position-relative">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
                        <div class="col">
                            <div class=" d-flex justify-content-center align-items-center gap-2 rounded bg-light shadow-sm p-3 h-100">
                                <label for="order-by" style="white-space: nowrap">Order By</label>
                                <select class="form-select" id="order-by" aria-label="Default select example" name="order-by">
                                    <option value="0" selected>None</option>
                                    <option value="name" @selected(isset($_GET['order-by']) && $_GET['order-by'] == 'name')>Name</option>
                                    <option value="price" @selected(isset($_GET['order-by']) && $_GET['order-by'] == 'price')>Price</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class=" d-flex justify-content-center align-items-center gap-2 rounded bg-light shadow-sm p-3 h-100">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="order" id="order-asc" checked value="asc">
                                    <label class="form-check-label" for="order-asc">
                                      Ascending
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="order" id="order-desc">
                                    <label class="form-check-label" for="order-desc">
                                      Descending
                                    </label>
                                  </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class=" d-flex justify-content-center align-items-center gap-2 rounded bg-light shadow-sm p-3">
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
                    </div>
                    @isset($_REQUEST['query'])
                        <input type="hidden" name="query" value="{{ $_REQUEST['query'] }}">
                    @endisset
                    @isset($_REQUEST['category'])
                        <input type="hidden" name="category" value="{{ $_REQUEST['category'] }}">
                    @endisset
                    <input type="submit" value="Filter" class="btn btn-secondary bg-gradient align-self-center position-absolute top-100 start-50 translate-middle">
                </form>
            </div>            
        </div>
    </div>
    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 bg-white rounded shadow d-flex flex-column gap-3" id="products">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                    @foreach ($products as $product)
                        @guest
                            <x-product :product="$product" :guest="true" :settings="$settings" />
                        @else
                            <x-product :product="$product" :settings="$settings"/>
                        @endguest
                    @endforeach
                </div>
                @if ($products->hasPages())
                    <hr>
                    <div id="pagination-liks-products">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
    @auth
    <a href="{{ route('cart') }}" type="button" class="btn btn-dark view-on-scroll" id="scrollButton">
        <i class="fas fa-shopping-cart position-relative">
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle d-none" id="cart-indicator">
            </span>
        </i>
    </a>
    <script>
        var scrollButton = document.getElementById('scrollButton');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 500) {
                scrollButton.classList.remove('view-on-scroll');
            } else {
                scrollButton.classList.add('view-on-scroll');
            }
        });

        cart();
    </script>
    @endauth
    <script>
        liveSearchListener();
        addTagToPaginationLinks('pagination-liks-products', 'products');
    </script>
</x-app-layout>