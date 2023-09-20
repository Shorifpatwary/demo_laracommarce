@extends('layouts.app', ['title' => 'Edit Shop Category'])

@section('dashboard-content')
<!-- Content Header (Page header) -->

<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    {{-- your content start--}}
    <div class="row d-flex justify-content-center align-content-center">
      <!-- Center the row -->
      <div class="col-md-6">
        <!-- Adjust the column size as needed -->
        <div class="card">
          <div class="card-body">
            <form action="{{ route('category.update' , $category->id) }}" method="Post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              {{-- category name --}}
              <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control @error('name')  is-invalid @enderror" id="name" name="name"
                  value="{{old('name' , $category->name)}}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="emailHelp" class="form-text text-muted">This is your main category</small>
              </div>

              {{-- parent category --}}
              <div class="form-group">
                <small for="parent_id">Category/Subcategory <span class="text-info">optional</span></small>
                <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id" id="parent_id">
                  <option disabled="">== Choose category ==</option>
                  {{-- AVOIDING::THIS WILL GET ERROR MESSAGE FORM SERVER. Ensure the current category is not its own
                  parent --}}
                  @foreach($parent_category as $row)
                  @php
                  $subcategories = DB::table('categories')->where('parent_id', $row->id)->get();
                  @endphp
                  {{-- @if ($category->id != $row->id) --}}
                  <!-- Ensure the current category is not its own parent -->
                  <option class="text-danger" value="{{ $row->id }}" {{ old('parent_id', $category->parent_id) ==
                    $row->id ?
                    'selected' : '' }}>
                    {{ $row->name }}
                  </option>
                  {{-- @endif --}}
                  @foreach($subcategories as $subcategory)
                  {{-- @if ($category->id != $subcategory->id) --}}
                  <!-- Ensure the current category is not its own parent -->
                  <option value="{{ $subcategory->id }}" {{ old('parent_id', $category->parent_id) == $subcategory->id ?
                    'selected' : '' }}>
                    -- {{ $subcategory->name }}
                  </option>
                  {{-- @endif --}}
                  @endforeach
                  @endforeach
                </select>
                @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              {{-- image --}}
              <div class="form-group">
                <label for="image">Main image <span class="text-danger">*</span></label><br>

                <input type="file" name="image" accept="image/*" value="{{old('image' , $category->image)}}"
                  class="dropify input_images @error('image') is-invalid @enderror"
                  data-allowed-file-extensions="jpg jpeg png gif webp" data-max-file-size="300k"
                  data-default-file="{{ asset('files/category-image/' . $category->image) }}">

                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              {{-- description --}}
              <div class="form-group">
                <label for="description">category description</label>
                <textarea class="form-control textarea @error('description') is-invalid @enderror" name="description"
                  id="description" minlength="50">{{ old('description' , $category->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              {{-- icon --}}
              <div class="form-group">
                <label for="icon">Category icon <span class="text-danger">*</span> </label>
                <input type="text" class="form-control @error('icon')  is-invalid @enderror" id="icon" name="icon"
                  value="{{old('icon' , $category->icon)}}" required>
                @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="emailHelp" class="form-text  text-capitalize text-muted">copy and paste icon class name only
                  from
                  <a class="text-capitalize" target="_blank" href="https://fontawesome.com/search?m=free&o=r">font
                    awesome icons here version 6 </a>like this [ <b>fa-solid fa-house</b> ]
                </small>
              </div>

              <button type="Submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- your content end--}}
  </div>
  <!--/. container-fluid -->
</section>

<!-- /.content -->

@push('css-link')
{{-- dropify --}}
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

@endpush

@pushOnce('js-link')

{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


{{-- dropify --}}
<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

{{-- summernote --}}
<script src="{{ asset('') }}plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
     // Summernote
     $('.textarea').summernote()
     })
</script>

<script>
  $(document).ready(function(){      
    $('.dropify').dropify();  //dropify image
  }); 
</script>

@endPushOnce

@endsection