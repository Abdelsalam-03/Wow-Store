<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Product Page</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
</head>
<body>
    <style type="text/css">
        img {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
        
    </style>
    <img src="{{$product->photo ? asset('storage/' . $product->photo) : ''}}" alt="image">
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
        <input type="number" name="stock" value="{{ $product->stock }}">
        @error('stock')
            {{$message}}
        @enderror
        <label for="photo" class="form-label">Photo</label>
        <input type="file" name="image" class="form-control image" id="photo">
        <input type="hidden" name="photo" class="imageField">
        <textarea name="description" id="" cols="30" rows="10" value="Hi"></textarea> 
        <input type="submit" value="Update">
    </form>


    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-7 col-lg-8">
                                <div>
                                    <img id="image">
                                </div>
                            </div>
                            <div class="col-12 col-md-5 col-lg-4">
                                <div>
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop" data-bs-dismiss="modal">Crop</button>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/cropper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>

<script>

    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper,reader,file;
  

    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 3/2,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 600,
            height: 400,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var imageField = document.querySelector('.imageField');
                var base64data = reader.result;
                imageField.value = base64data;
            };
        });
    });

</script>



</body>
</html>