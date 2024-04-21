<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categories</title>
</head>
<body>
    
    <a href="{{route('admin.home')}}">Home</a>
    <hr>
    Categories 
    <a href="{{route('admin.categories.create')}}">Add Category</a>
    <hr>
    @foreach ($categories as $category)
        <h4>Name: {{ $category->name }}</h4>
        <a href="{{route('admin.categories.show', ["category" => $category->id])}}">Show</a>
        <a href="{{route('admin.categories.edit', ["category" => $category->id])}}">Edit</a>
        <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete">
        </form>
    @endforeach
</body>
</html>