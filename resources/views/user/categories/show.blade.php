<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categories - {{ $category->name }}</title>
</head>
<body>
    <h1>{{ $category->name }}</h1>
    @foreach ($products as $product)
        <h1>name - {{ $product->name }}</h1>
        <h1>price - {{ $product->price }}</h1>
        <hr>
    @endforeach
</body>
</html>