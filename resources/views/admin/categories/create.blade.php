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
                Create Category
            </h2>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="d-flex flex-column gap-2">
                    @csrf
                    <div>
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                            <script>
                                viewAlert('danger', "{{ $message }}")
                            </script>
                        @enderror
                    </div>
                    <div>
                        <label for="return">Return to this page</label>
                        <input type="checkbox" name="return" id="return" class="mx-2">
                    </div>
                    <input type="submit" value="Create" class="btn btn-primary align-self-start ">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
