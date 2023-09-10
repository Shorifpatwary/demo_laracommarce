@extends('layouts.app', ['title' => 'Create Coupon'])

@push('css-link')



{{-- bootstrap tags input css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css"
  integrity="sha512-3uVpgbpX33N/XhyD3eWlOgFVAraGn3AfpxywfOTEQeBDByJ/J7HkLvl4mJE1fvArGh4ye1EiPfSBnJo2fgfZmg=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- dropify --}}
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

{{-- switch css --}}
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/css/bootstrap-switch.min.css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<style type="text/css">
  .bootstrap-tagsinput .tag {
    background: #428bca;
    border: 1px solid white;
    padding: 1 6px;
    padding-left: 2px;
    margin-right: 2px;
    color: white;
    border-radius: 4px;
  }

  /* toogle checkbox */
  .toggle {
    --width: 80px;
    --height: calc(var(--width) / 3);

    position: relative;
    display: inline-block;
    width: var(--width);
    height: var(--height);
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
    cursor: pointer;
  }

  .toggle input {
    display: none;
  }

  .toggle .labels {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    font-size: 12px;
    font-family: sans-serif;
    transition: all 0.4s ease-in-out;
  }

  .toggle .labels::after {
    content: attr(data-off);
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    color: #4d4d4d;
    background-color: #f19999;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
    transition: all 0.4s ease-in-out;
  }

  .toggle .labels::before {
    content: attr(data-on);
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    color: #ffffff;
    background-color: #4fe132;
    text-align: center;
    opacity: 0;
    text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
    transition: all 0.4s ease-in-out;
  }

  .toggle input:checked~.labels::after {
    /* flip 180deg */
    transform: rotateY(180deg);
    opacity: 0;
  }

  .toggle input:checked~.labels::before {
    transform: rotateY(180deg) scale(-1, 1);
    opacity: 1;
  }
</style>

@endpush

@pushOnce('js-link')

{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

{{-- <script type="text/javascript"
  src="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js" defer></script> --}}

{{-- dropify --}}
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

{{-- <script src="{{ asset('') }}plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/min/dropzone.min.js" defer></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/4.0.0-alpha.1/js/bootstrap-switch.min.js">
</script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>



<script>
  $(document).ready(function(){      
    $('.dropify').dropify();  //dropify image
  }); 
</script>

{{-- toggle checkbox --}}
<script type="text/javascript">
  // Get all elements with class "toggleCheckbox"
  const toggleCheckboxes = document.querySelectorAll(".toggleCheckbox");

  // Loop through each checkbox element
  toggleCheckboxes.forEach((checkbox) => {
    // Check the initial value and set the checkbox accordingly
    checkbox.checked = checkbox.value === "1";

    // Add an event listener to toggle the checkbox when clicked
    checkbox.addEventListener("click", function () {
      // Toggle the value between "1" and "0"
      this.value = this.value === "1" ? "0" : "1";
    });
  });
</script>

{{-- child category request --}}
<script type="text/javascript">
  // Define a function to handle the change event on the "subcategory_id" select element
document.getElementById("subcategory_id").addEventListener("change", function () {
  // Get the selected value from the "subcategory_id" select element
  var id = this.value;

  // Construct the URL for the AJAX request
  var url = "/get-child-category/" + id;

  // Send a GET request using the fetch method
  fetch(url)
    .then(function (response) {
      // Check if the response status is OK (200)
      if (response.ok) {
        return response.json();
      } else {
        throw new Error("Failed to fetch data");
      }
    })
    .then(function (data) {
      // Get a reference to the "childcategory_id" select element
      var childcategorySelect = document.querySelector('#childcategory_id');

      // Clear the options in the "childcategory_id" select element
      // Add the optional "Select Child Category" option as the first option
      
      childcategorySelect.innerHTML = '';

      // Add the optional "Select Child Category" option as the first option
      var defaultOption = document.createElement("option");
      defaultOption.value = ""; // No value for the default option
      defaultOption.textContent = "Select Child Category";
      childcategorySelect.appendChild(defaultOption);

      // Iterate through the received data and add options to the 
      // "childcategory_id" select element

      data.forEach(function (item) {
        var option = document.createElement("option");
        option.value = item.id;
        option.textContent = item.name;
        childcategorySelect.appendChild(option);
      });
    })
    .catch(function (error) {
      console.error(error);
    });
});
</script>


@endPushOnce

@section('dashboard-content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard v2</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v2</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
{{-- show any error TESTING --}}
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    {{-- your content start--}}
    <!-- Info boxes -->
    {{-- <div class="row justify-content-center"> --}}

      <!-- /.card-header -->
      {{-- form start --}}
      <form action="{{ route('product.store') }}" id="createProductFormId" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <!-- left column -->
          <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Product</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  {{-- product name --}}
                  <div class="form-group col-lg-6">
                    <label for="name">Product Name <span class="text-danger">*</span> </label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror " name="name"
                      value="{{ old('name') }}" required="" maxlength="255">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- product code --}}
                  <div class="form-group col-lg-6">
                    <label for="code">Product Code <span class="text-danger">*</span> </label>
                    <input type="text" id="code" class="form-control @error('code') is-invalid @enderror"
                      value="{{ old('code') }}" name="code" required="" minlength="2" maxlength="50">
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                {{-- product category --}}
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Category/Subcategory <span class="text-danger">*</span> </label>
                    <select class="form-control" name="subcategory_id" id="subcategory_id">
                      <option disabled="" selected="">==choose category==</option>
                      @foreach($category as $row)
                      @php
                      $subcategories=DB::table('categories')->where('parent_id',$row->id)->get();
                      @endphp
                      <option class="text-danger" disabled="">{{ $row->name }}</option>
                      @foreach($subcategories as $subcategory)
                      <option value="{{ $subcategory->id }}" {{ old('subcategory_id')==$row->id ? 'selected' : '' }}> --
                        {{ $subcategory->name }}</option>
                      @endforeach
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="childcategory_id">Child category<span class="text-danger">*</span> </label>
                    <select class="form-control" name="childcategory_id" id="childcategory_id">
                    </select>
                  </div>
                </div>

                <div class="row">
                  {{-- brand --}}
                  <div class="form-group col-lg-6">
                    <label for="brand_id">Brand <span class="text-danger">*</span></label>
                    <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id" id="brand_id"
                      required="">
                      <option value="" disabled selected>Select a Brand</option>
                      @foreach($brand as $row)
                      <option value="{{ $row->id }}" {{ old('brand_id')==$row->id ? 'selected' : '' }}>
                        {{ $row->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- comment pickup point for now --}}
                  <div class="form-group col-lg-6">
                    <label for="pickup_point_id">Pickup Point</label>
                    <select class="form-control @error('pickup_point_id') is-invalid @enderror" name="pickup_point_id"
                      id="pickup_point_id">
                      <option value="" disabled selected>Select a Pickup Point</option>
                      @foreach($pickup_point as $row)
                      <option value="{{ $row->id }}" {{ old('pickup_point_id')==$row->id ? 'selected' : '' }}>
                        {{ $row->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('pickup_point_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  {{-- unit --}}
                  <div class="form-group col-lg-6">
                    <label for="unit">Unit<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit"
                      value="{{ old('unit') }}" id="unit" required="" minlength="5" maxlength="100">
                    @error('unit')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- tags --}}
                  <div class="form-group col-lg-6">
                    <label for="tags">Tags</label><br>
                    <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags"
                      value="{{ old('tags') }}" id="tags" data-role="tagsinput" minlength="5" maxlength="255">
                    @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                </div>
                <div class="row">
                  {{-- purchase price --}}
                  <div class="form-group col-lg-4">
                    <label for="purchase_price">Purchase Price</label>
                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                      name="purchase_price" value="{{ old('purchase_price') }}" id="purchase_price">
                    @error('purchase_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- selling price --}}
                  <div class="form-group col-lg-4">
                    <label for="selling_price">Selling Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('selling_price') is-invalid @enderror"
                      name="selling_price" value="{{ old('selling_price') }}" id="selling_price" required="">
                    @error('selling_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- descount price --}}
                  <div class="form-group col-lg-4">
                    <label for="discount_price">Discount Price</label>
                    <input type="number" class="form-control @error('selling_price') is-invalid @enderror"
                      name="discount_price" value="{{ old('discount_price') }}" id="discount_price">
                    @error('discount_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  {{-- warehouse --}}
                  <div class="form-group col-lg-6">
                    <label for="warehouse_id">Warehouse <span class="text-danger">*</span></label>
                    <select class="form-control @error('warehouse_id') is-invalid @enderror" name="warehouse_id"
                      id="warehouse_id" required="">
                      <option value="" disabled selected>Select a Warehouse</option>
                      @foreach($warehouse as $row)
                      <option value="{{ $row->id }}" {{ old('warehouse_id')==$row->id ? 'selected' : '' }}>
                        {{ $row->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('warehouse_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- stock --}}
                  <div class="form-group col-lg-6">
                    <label for="stock_quantity">Stock</label>
                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                      name="stock_quantity" value="{{ old('stock_quantity') }}" id="stock_quantity">
                    @error('stock_quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  {{-- color --}}
                  <div class="form-group col-lg-6">
                    <label for="color">Color</label><br>
                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                      value="{{ old('color') }}" data-role="tagsinput" name="color" id="color" minlength="2"
                      maxlength="100" />
                    @error('color')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  {{-- size --}}
                  <div class="form-group col-lg-6">
                    <label for="size">Size</label><br>
                    <input type="text" class="form-control @error('size') is-invalid @enderror"
                      value="{{ old('size') }}" data-role="tagsinput" name="size" id="size" minlength="2"
                      maxlength="100" />
                    @error('size')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  {{-- product details / descripton --}}
                  <div class="form-group col-lg-12">
                    <label for="description">Product Details</label>
                    <textarea class="form-control textarea @error('description') is-invalid @enderror"
                      name="description" id="description" minlength="50">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  {{-- video url --}}
                  <div class="form-group col-lg-12">
                    <label for="video">Video url</label>
                    <input type="url" class="form-control @error('video') is-invalid @enderror" name="video"
                      value="{{ old('video') }}" placeholder="Place your video url" id="video" minlength="5"
                      maxlength="100">
                    @error('video')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-danger text-capitalize">Video url</small>
                  </div>

                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.card -->
          <!-- right column -->
          <div class="col-md-4">
            <!-- Form Element sizes -->
            <div class="card card-primary">
              <div class="card-body">
                {{-- thumbnail --}}
                <div class="form-group">
                  <label for="thumbnail">Main Thumbnail <span class="text-danger">*</span></label><br>

                  <input type="file" name="thumbnail" required="" accept="image/*"
                    class="dropify input_images @error('thumbnail') is-invalid @enderror"
                    data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="300k">

                  <div class="input_images" style="padding-top: .5rem;"></div>
                  @error('thumbnail')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- product images --}}
                <div class="form-group max-h-8">
                  <label for="images" class="text-capitalize">Product images <span
                      class="text-danger">*</span></label><br>

                  <input type="file" multiple name="images[]" class="images" id="images">
                  @error('images')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- testing 2 --}}
                <!-- Main Thumbnail -->
                <br>
                {{-- is fearuce checkbox --}}
                <div class="">
                  <label class="text-capitalize col-8 mt-0 gap-2
                  ">featured</label>
                  <label class="toggle">
                    <input class="toggleCheckbox" type="checkbox" name="featured" value="{{old('featured' , 1 )}}" />
                    <span class="labels" data-on="ON" data-off="OFF"></span>
                  </label>
                </div>
                {{-- is today checkbox --}}
                <div class="">
                  <label class="text-capitalize col-8
                  ">tody deal</label>
                  <label class="toggle">
                    <input class="toggleCheckbox" type="checkbox" name="today_deal"
                      value="{{old('today_deal' , 0 )}}" />
                    <span class="labels" data-on="ON" data-off="OFF"></span>
                  </label>
                </div>

                <div class="">
                  <label class="text-capitalize col-8
                  ">add to slider</label>
                  <label class="toggle">
                    <input class="toggleCheckbox" type="checkbox" name="product_slider"
                      value="{{old('product_slider' , 0 )}}" />
                    <span class="labels" data-on="ON" data-off="OFF"></span>
                  </label>
                </div>

                <div class="d-flex-inline gap-2">
                  <label class="text-capitalize col-8
                  ">add to trandy</label>
                  <label class="toggle">
                    <input class="toggleCheckbox" type="checkbox" value="{{old('trendy' , 0 )}}" name="trendy" />
                    <span class="labels" data-on="ON" data-off="OFF"></span>
                  </label>
                </div>

                <div class="d-flex-inline gap-2">
                  <label class="text-capitalize col-8
                  ">status</label>
                  <label class="toggle">
                    <input class="toggleCheckbox" type="checkbox" value="{{old('status' , 1 )}}" name="status" />
                    <span class="labels" data-on="ON" data-off="OFF"></span>
                  </label>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <button class="btn btn-info ml-2 btn-block" id="submitFormButton" type="submit">Submit</button>
        </div>

      </form>
      {{-- form end --}}

      {{-- your content end--}}
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection

{{-- <input type="file" id="dropzone" name="thumbnail" required="" accept="image/*"
  class="dropify input_images dropzone thumbnail-dropzone @error('thumbnail') is-invalid @enderror"
  data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="300k"> --}}

{{-- Product Images --}}
{{-- <input type="file" name="images[]" required="" id="imagesDropzone" accept="image/*"
  class="dropify input_images imagesDropzone images-dropzone @error('images') is-invalid @enderror"
  data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="300m" multiple> --}}

{{-- testing --}}
{{-- Main Thumbnail --}}
{{-- <input type="file" id="thumbnailDropzone" name="thumbnail" required="" accept="image/*"
  class="dropify input_images thumbnailDropzone thumbnail-dropzone @error('thumbnail') is-invalid @enderror"
  data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="300k"> --}}

<!-- Product Images -->
{{-- <input type="file" name="images[]" required="" id="imagesDropzone" accept="image/*"
  class="dropify input_images imagesDropzone images-dropzone @error('images') is-invalid @enderror"
  data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="300m" multiple> --}}

{{-- product images --}}
{{-- <div class="form-group">
  <label for="images">Product Images<span class="text-danger">*</span></label><br>
  <input type="file" name="images[]" required="" accept="image/*"
    class="dropify input_images images-dropzone @error('images') is-invalid @enderror"
    data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="300m" multiple>
  <div class="input_images" style="padding-top: .5rem;"></div>
  @error('images')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div> --}}