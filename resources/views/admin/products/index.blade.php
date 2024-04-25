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
                Products
            </h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
    </x-slot>
    @if (count($products))
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" required>
                        <input type="submit" value="Search" class="btn btn-dark">
                    </div>
                </form>
                <form action="" class="d-flex flex-column justify-content-center gap-4">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                        <div class="col">
                            <div class=" d-flex justify-content-center align-items-center gap-2 rounded bg-light shadow-sm p-3 h-100">
                                <label for="order-by" style="white-space: nowrap">Order By</label>
                                <select class="form-select" id="order-by" aria-label="Default select example" name="order-by">
                                    <option value="0" selected>None</option>
                                    <option value="name">Name</option>
                                    <option value="price">Price</option>
                                    <option value="stock">Stock</option>
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
                    <input type="submit" value="Filter" class="btn btn-outline-dark align-self-center">
                </form>
                <div class="d-flex flex-column">
                    <hr class="border-danger">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 gy-4 justify-content-center">
                        @foreach ($products as $product)
                            <x-admin-product :product="$product" :settings="$settings" />
                        @endforeach
                    </div>
                    @if ($products->hasPages())
                        <div>
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
        
    @else
    <div class="p-4 text-center bg-white text-danger shadow">
        <h2>There is no Products to show.</h2>
    </div>
    @endif
</x-app-layout>
