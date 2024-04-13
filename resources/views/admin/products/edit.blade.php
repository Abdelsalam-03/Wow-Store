<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product Page</title>
</head>
<body>
    <form action="{{route('products.update', ['product' => $product->id])}}" method="POST">
        @method('PUT')
        @csrf
        <input type="text" name="name" value="{{$product->name}}">
        @error('name')
            {{$message}}
        @enderror
        <input type="text" name="price" value="{{$product->price}}">
        @error('price')
            {{$message}}
        @enderror
        <select name="category" id="">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected($product->category->id == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <input type="submit" value="Update">
    </form>
</body>
</html>