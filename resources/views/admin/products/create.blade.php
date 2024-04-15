<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product Page</title>
</head>
<body>
    <form action="{{route('products.store')}}" method="POST">
        @csrf
        <input type="text" name="name" value="{{old('name')}}">
        @error('name')
            {{$message}}
        @enderror
        <input type="text" name="price" value="{{old('price')}}">
        @error('price')
            {{$message}}
        @enderror
        <select name="category" id="">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <input type="number" name="quantity" value="{{old('quantity')}}">
        @error('quantity')
            {{$message}}
        @enderror
        <label for="return">Return to this page</label>
        <input type="checkbox" name="return" id="return" @checked(isset($checked))>
        <input type="submit" value="Add">
    </form>
</body>
</html>