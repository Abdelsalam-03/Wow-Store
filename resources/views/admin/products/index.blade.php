<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>
<body>
    <a href="{{route('admin.home')}}">Home</a>
    <hr>
    Products 
    <a href="{{route('admin.products.create')}}">Add Product</a>
    <hr>
    @foreach ($products as $product)
        <h4>Name: {{ $product->name }}</h4>
        <h4>Price: {{ $product->price }}</h4>
        <h4>Category: {{ $product->category->name }}</h4>
        <h4>Stock: {{ $product->stock }}</h4>
        <a href="{{route('admin.products.show', ["product" => $product->id])}}">Show</a>
        <a href="{{route('admin.products.edit', ["product" => $product->id])}}">Edit</a>
        <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete">
        </form>
    @endforeach
</body>
</html>