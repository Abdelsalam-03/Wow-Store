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
                Admins
            </h2>
            <a href="{{ route('manager.admins.create') }}" class="btn btn-primary">Add Admin</a>
        </div>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="text" name="email" class="form-control" value="{{ isset($_GET['email'])? $_GET['email']: '' }}">
                        <input type="submit" value="Find" class="btn btn-dark">
                    </div>
                </form>
            @if (count($admins))
                <div class="d-flex flex-column">
                    <div class="row align-items-center">
                        <div class="text-center col-3 ">
                            Name
                        </div>
                        <div class="text-center col-6 ">
                            Email
                        </div>
                        <div class="col-3">
                            Actions
                        </div>
                    </div>
                    <hr>
                    @foreach ($admins as $admin)
                        <div class="row align-items-center">
                            <div class="text-center col-3 ">
                                {{ $admin->name }}
                            </div>
                            <div class="text-center col-6 ">
                                {{ $admin->email }}
                            </div>
                            <div class="col-3">
                                <div class="d-flex flex-wrap gap-3">
                                    <form action="{{ route('manager.admins.suspend', ['admin' => $admin->id]) }}" method="POST">
                                        @csrf 
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Suspend</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    @if ($admins->hasPages())
                        <div>
                            {{ $admins->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
                @else
                <div class="p-4 text-center text-danger">
                    <h2>There is no Admins to show.</h2>
                </div>
                @endif
            </div>
        </div>
    </div>
        
</x-app-layout>
