<x-app-layout>
    @if(session('success'))
    <script>
        viewAlert('success', "{{ session('success') }}");
    </script>
    @endif
    @if(session('fail'))
    <script>
        viewAlert('danger', "{{ session('fail') }}")
    </script>
    @endif
    <x-slot name="adminLinks">
    </x-slot>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                Create Product
            </h2>
        </div>
    </x-slot>
    <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">
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
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg d-flex flex-column gap-3">
                <form action="{{route('admin.products.store')}}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div>
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required>
                        @error('name')
                            <script>
                                viewAlert('danger', "{{$message}}");
                            </script>
                        @enderror
                    </div>
                    <div>
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 gy-3">
                        <div class="col">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{old('price')}}" required>
                            @error('price')
                                <script>
                                    viewAlert('danger', "{{$message}}");
                                </script>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{old('stock')}}">
                            @error('stock')
                                <script>
                                    viewAlert('danger', "{{$message}}");
                                </script>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" name="image" class="form-control image" id="photo">
                        <input type="hidden" name="photo" class="imageField" value="{{ old('photo') }}" required>
                        @error('photo')
                            <script>
                                viewAlert('danger', "{{$message}}");
                            </script>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="10" value="afdad">{{ old('description') }}</textarea>    
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <label for="return" class="form-label m-0">Return to this page</label>
                        <input type="checkbox" name="return" id="return">
                    </div>
                    <input type="submit" value="Create" class="btn btn-primary align-self-start">
                </form>
            </div>
        </div>
    </div>
    
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
</x-app-layout>
