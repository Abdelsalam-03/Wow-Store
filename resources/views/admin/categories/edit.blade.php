<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
</head>
<body>
    <div class="container">
        <form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="POST" class="row-md d-flex-md">
            @csrf
            @method('PUT')
            <div class="mb-3 col-md-7">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $category->name }}">
                @error('name')
                    <div class="text-danger m-2">{{$message}}</div>
                @enderror
              </div>
                <div class="col-md-7">
                    <input type="submit" value="Update" class="form-control btn btn-success">
                </div>
        </form>
    </div>
</body>
</html>