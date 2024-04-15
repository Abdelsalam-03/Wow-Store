<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categories</title>
</head>
<body>
    @foreach ($categories as $category)
        <a href="{{ route('category', ['category' => $category->id]) }}"><h1>{{ $category->name }}</h1></a>
    @endforeach
</body>
</html>