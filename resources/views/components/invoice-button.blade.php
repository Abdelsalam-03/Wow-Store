<div class="d-flex align-items-center">
    <button type="button" class="btn btn-light" @disabled($status == 'pending' || $status == 'canceled') data-bs-toggle="modal" data-bs-target="#invoice-modal">
        <i class="fas fa-receipt  position-relative">
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle {{ $status == 'pending' || $status == 'canceled' ? 'd-none': '' }}" id="cart-indicator">
                
            </span>
        </i>
        Invoice
    </button>
    <div class="modal fade" id="invoice-modal" tabindex="-1" aria-labelledby="invoice-modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <h3 class="title">Invoice - {{ $order->id }}</h3>
                        <div class="" style="width: 30px">
                            <x-application-logo />
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="date d-flex flex-row justify-content-between">
                            <p class="fw-bold m-0">Date: </p>
                            <p class="text-sm m-0">{{ date('Y/m/d - H:i', $order->date) }}</p>
                        </div>
                        <div class="address d-flex flex-row justify-content-between">
                            <p class="fw-bold m-0">Address: </p>
                            <p class="text-sm m-0">{{ explode('contact -', $order->address)[0] }}</p>
                        </div>
                        <div class="address d-flex flex-row justify-content-between">
                            <p class="fw-bold m-0">Contact:</p>
                            <p class="text-sm m-0">{{ explode('contact -', $order->address)[1] }}</p>
                        </div>
                    </div>
                    <table class="table border border-2 border-dark">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalItems = 0;
                                $totalPrice = 0;
                            @endphp
                            @foreach ($orderProducts as $product)
                            @php
                                $totalItems+= $product->quantity;
                                $totalPrice+= $product->price * $product->quantity;
                            @endphp
                            <tr>
                                <th scope="row">{{ $product->product_id }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price * $product->quantity }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th scope="row">Total({{$totalItems}})</th>
                                <td colspan="2"></td>
                                <td class="fw-bold">{{ $totalPrice }}</td>
                              </tr>
                        </tbody>
                      </table>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" disabled>Print</button>
            </div>
          </div>
        </div>
      </div>
</div>