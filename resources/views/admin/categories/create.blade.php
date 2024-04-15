<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Category Page</title>
</head>
<body>
    <form action="{{route('categories.store')}}" method="POST">
        @csrf
        <input type="text" name="name" value="{{old('name')}}">
        @error('name')
            {{$message}}
        @enderror
        <label for="return">Return to this page</label>
        <input type="checkbox" name="return" id="return">
        <input type="submit" value="Add">
    </form>
</body>
</html>