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
    @foreach ($products as $product)
        {{ $product->name }}<br>
        {{ $product->price }}<br>
        {{ $product->category->name }}<br>
        <a href="{{ route('user.product', ['product' => $product->id]) }}">View</a>
        <button onclick="addToCart({{$product->id}})">Add To Cart</button>
        <hr>
    @endforeach
    <script>
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
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>