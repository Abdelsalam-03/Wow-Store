<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categories</title>
</head>
<body>
    Categories 
    <a href="{{route('categories.create')}}">Add Category</a>
    <hr>
    @foreach ($categories as $category)
        <h4>Name: {{ $category->name }}</h4>
    @endforeach
</body>
</html>