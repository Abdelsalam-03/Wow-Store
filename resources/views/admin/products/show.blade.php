<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products - {{ $product->name }}</title>
</head>
<body>
    <h1>{{ $product->name }}</h1>
    <h1>{{ $product->price }}</h1>
    <h1>{{ $product->category->name }}</h1>
    <h1>{{ $product->quantity }}</h1>
</body>
</html>