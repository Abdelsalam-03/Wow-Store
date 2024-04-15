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
        <hr>
    @endforeach
</body>
</html>