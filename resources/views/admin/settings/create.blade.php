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
    <x-slot name="orders">
        <x-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders')">
            Orders
        </x-nav-link>
    </x-slot>
    <x-slot name="ordersResponsive">
        <x-responsive-nav-link :href="route('admin.orders')" :active="request()->routeIs('admin.orders')">
            Orders
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="categories">
        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
            Categories
        </x-nav-link>
    </x-slot>
    <x-slot name="categoriesResponsive">
        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
            Categories
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="products">
        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
            products
        </x-nav-link>
    </x-slot>
    <x-slot name="productsResponsive">
        <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.index')">
            Products
        </x-responsive-nav-link>
    </x-slot>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight m-0">
                Set The Settings
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
                <form action="{{route('admin.settings.set')}}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div>
                        <label for="shipping_cost" class="form-label">Shipping Cost</label>
                        <input type="text" name="shipping_cost" id="shipping_cost" class="form-control" value="{{old('shipping_cost')}}" required>
                        @error('shipping_cost')
                            <script>
                                viewAlert('danger', "{{$message}}");
                            </script>
                        @enderror
                    </div>
                    <div>
                        <label for="default_photo" class="form-label">Default Product Photo</label>
                        <input type="file" name="default_photo" class="form-control image" id="default_photo">
                        <input type="hidden" name="photo" class="imageField" value="{{ old('photo') }}" required>
                        @error('photo')
                            <script>
                                viewAlert('danger', "{{$message}}");
                            </script>
                        @enderror
                    </div>
                    <input type="submit" value="Set" class="btn btn-primary align-self-start">
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
