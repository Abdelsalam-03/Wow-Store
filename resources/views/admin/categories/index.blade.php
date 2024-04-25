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
                Categories
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>
        </div>
    </x-slot>
    @if (count($categories))
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" required>
                        <input type="submit" value="Search" class="btn btn-dark">
                    </div>
                </form>
                <div class="d-flex flex-column">
                    <hr class="border-danger">
                    @foreach ($categories as $category)
                        <div class="row align-items-center">
                            <div class="text-center col-6 col-md-4">
                                {{ $category->name }}
                            </div>
                            <div class="text-center col-6 col-md-4">
                                Products ({{ count($category->products) }})
                            </div>
                            <div class="col-12 p-2 d-md-none"></div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex flex-row justify-content-center gap-3">
                                    <a href="{{ route('admin.categories.show', ['category' => $category->id]) }}" class="btn btn-outline-primary">Show</a>
                                    <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="btn btn-outline-secondary">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    @if ($categories->hasPages())
                        <div>
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
        
    @else
    <div class="p-4 text-center bg-white text-danger shadow">
        <h2>There is no categories to show.</h2>
    </div>
    @endif
</x-app-layout>
