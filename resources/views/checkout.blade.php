<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
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
                                <button class="btn btn-primary align-self-center" type="submit">Change</button>
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
                                <button class="btn btn-primary align-self-center" type="submit">Save</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach ($items as $product)
        @if ($product->quantity > $product->stock)
            The Quntity is out of stock for {{$product->name}}
        @else
            {{$product->name}} Is Ready
        @endif
        <br>
    @endforeach
    <script>
        disableAddressForms();
    </script>
</x-app-layout>