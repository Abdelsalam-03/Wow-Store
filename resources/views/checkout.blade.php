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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 d-flex flex-column gap-4">
            <div class="row g-4 justify-content-center">
                <div class="col col-12 col-sm-8 col-md-6">
                    <div class="p-4 bg-white rounded shadow d-flex flex-column text-secondary">
                        <h3 class="text-center">Address Information</h3>
                        <hr>
                        @if ($address)
                            <form action="" class="d-flex flex-column address-form" onsubmit="createUserAddress()">
                                <div class="mb-3">
                                    <label for="district" class="form-label">District / City</label>
                                    <input type="text" class="form-control" name="district" id="district" required value="{{ $address->district }}">
                                </div>
                                <div class="mb-3">
                                    <label for="street" class="form-label">Street</label>
                                    <input type="text" class="form-control" name="street" id="street" required value="{{ $address->street }}">
                                </div>
                                <div class="mb-3">
                                    <label for="building" class="form-label">Building / Door</label>
                                    <input type="text" class="form-control" name="building" id="building" required value="{{ $address->building }}">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required value="{{ $address->phone }}">
                                </div>
                                <button class="btn btn-secondary align-self-center" type="submit">Change</button>
                            </form>
                        @else
                            <form action="" class="d-flex flex-column address-form" onsubmit="createUserAddress()">
                                <div class="mb-3">
                                    <label for="district" class="form-label">District / City</label>
                                    <input type="text" class="form-control" name="district" id="district" required>
                                </div>
                                <div class="mb-3">
                                    <label for="street" class="form-label">Street</label>
                                    <input type="text" class="form-control" name="street" id="street" required>
                                </div>
                                <div class="mb-3">
                                    <label for="building" class="form-label">Building / Door</label>
                                    <input type="text" class="form-control" name="building" id="building" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>
                                <button class="btn btn-secondary align-self-center" type="submit">Save</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col col-12 col-sm-8 col-md-6">
                    <div class="p-4 bg-white rounded shadow d-flex flex-column text-secondary">
                        <div class="row">
                            <div class="col-3">
                                Product
                            </div>    
                            <div class="col-3">
                                Quantity
                            </div>    
                            <div class="col-3">
                                Price
                            </div>    
                            <div class="col-3">
                                Status
                            </div> 
                            <hr>   
                            @php
                                $totalProducts = 0;
                                $totalPrice = 0;
                            @endphp
                            @foreach ($items as $product)
                                <div class="col-3">
                                    {{ $product->name }}
                                </div>    
                                <div class="col-3">
                                    {{ $product->quantity }}
                                </div>    
                                <div class="col-3">
                                    {{ $product->price }}
                                </div>    
                                @if ($product->quantity > $product->stock)
                                    <div class="col-3 text-danger">
                                        <div class="d-flex flex-column">
                                            Out Of stock
                                            <a href="" class="link-primary" onclick="addToCart({{$product->product_id . ', ' . $product->stock}})">Adjust To {{ $product->stock }}</a>
                                            <a href="" class="link-danger" onclick="removeFromCart({{ $product->product_id }})">Delete</a>
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $totalProducts += $product->quantity;
                                        $totalPrice += ($product->quantity * $product->price);
                                    @endphp
                                    <div class="col-3 text-success">
                                        Ready
                                    </div>
                                @endif
                                <hr>
                            @endforeach
                            <div class="col">
                                Total({{ $totalProducts }}) <strong>{{ $totalPrice }}</strong>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8 col-sm-5 col-md-3 col-lg-2">
                    <form action="{{ route('checkout') }}" method="POST" class="d-flex justify-content-center">
                        @csrf
                        <button class="btn btn-lg btn-primary shadow">Confirm Order</button>
                    </form>
                    <div >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        disableAddressForms();
    </script>
</x-app-layout>