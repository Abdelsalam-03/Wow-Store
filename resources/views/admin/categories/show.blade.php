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
                {{ $category->name }}
            </h2>
            <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="btn btn-primary">Edit</a>
        </div>
    </x-slot>
    @if ($category->photo)
        <div class="container d-flex flex-column pt-4">
            <h4 class="text-center">Category Descriptive Image</h4>
            <img src="{{ asset('storage/' . $category->photo) }}" alt="image" class="rounded" style="max-height: 100vh">
        </div>
    @endif
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                @if (count($products))
                    <h3 class="text-center">Related Products</h3>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 justify-content-center gy-4">
                        @foreach ($products as $product)
                            <x-admin-product :product="$product" :settings="$settings"/>
                        @endforeach
                    </div>
                    @if ($products->hasPages())
                        <hr>
                        <div>
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <h3 class="text-center text-danger">No Products Here.</h3>
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>
