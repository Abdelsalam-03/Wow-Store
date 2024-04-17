<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>
<body>
    <form action="" method="GET">
        <input type="text" name="query" id="">
        <input type="submit" value="Search">
    </form>
    <hr>
    <button onclick="destroyCart()">Empty Cart</button>
    <hr>
    <div class="cart">

    </div>
    <hr>
    @foreach ($products as $product)
        {{ $product->name }}<br>
        {{ $product->price }}<br>
        {{ $product->category->name }}<br>
        <a href="{{ route('user.product', ['product' => $product->id]) }}">View</a>
        <button onclick="addToCart({{$product->id}})">Add To Cart</button>
        <hr>
    @endforeach
    <script>
        function cart() {
            fetch('/cart/all', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => response.json())
            .then(data => {
                fillCart(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        function addToCart(id) {
            const data = { productId: id };
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                fillSpecificCart(id);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        function destroyCart() {
            if (window.confirm("Are You Sure Want To Descard Card Content?")) {
                fetch('/cart/destroy', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    document.querySelector('.cart').innerHTML = '';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
        function fillCart(content) {
            cartElement = document.querySelector('.cart');
            content.forEach(element => {
                let component = document.createElement('div');                
                let id = document.createElement('p');                
                let quantity = document.createElement('p');
                let removeBotton = document.createElement('button');
                removeBotton.addEventListener('click', () => remove(element.product_id));
                quantity.className = 'quantity';
                id.innerHTML = 'Name : ' + element.product_id;
                quantity.innerHTML = element.quantity;
                removeBotton.innerHTML = 'Remove';
                component.id = element.product_id + 'cart';
                component.append(id);
                component.append(quantity);
                component.append(removeBotton);
                component.append(document.createElement('hr'));
                cartElement.appendChild(component);
            });
        }
        function fillSpecificCart(productId) {
            element = document.getElementById(productId + 'cart');
            if (element) {
                element.querySelector('.quantity').innerHTML = (+element.querySelector('.quantity').innerHTML + 1);
            } else {
                cartElement = document.querySelector('.cart');
                let component = document.createElement('div');                
                let id = document.createElement('p');                
                let quantity = document.createElement('p');
                let removeBotton = document.createElement('button');
                removeBotton.addEventListener('click', () => remove(productId));
                quantity.className = 'quantity';
                id.innerHTML = 'Name : ' + productId;
                quantity.innerHTML = 1;
                removeBotton.innerHTML = 'Remove';
                component.id = productId + 'cart';
                component.append(id);
                component.append(quantity);
                component.append(removeBotton);
                component.append(document.createElement('hr'));
                cartElement.appendChild(component);
            }
        }
        function remove(id) {
            fetch('/cart/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById(id + 'cart').remove();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        cart();
    </script>
</body>
</html>