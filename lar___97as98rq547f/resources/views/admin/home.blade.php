@php
    $isEdit = @$post ? true : false;
@endphp
@extends('admin.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection
@section('content')
    @include('media::modal')
  <div class="col-lg-12" >
   <div class="card">
      <div class="card-body">
      <h4 class="card-title">
        إعدادات الصفحة الرئيسية
      </h4>
      <form class="form-horizontal m-t-40" method="post" action="@if($isEdit) {{ $post->url->update  }} @else {{ route('posts.index') }} @endif" enctype="multipart/form-data" >
        @csrf
        
          <div class="form-group">
            <label for="title">عنوان</label>
            <div class="input-group mb-3">
                <input value="{{ old('firstviewids') ? old('firstviewids') : $firstview->firstviewids) }}" type="text" class="@if($errors->has('title')) is-invalid @endif form-control" placeholder="عنوان" name="title">

            </div>
          </div>

        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
            
            حفظ
            </button>
        
         </form>
          </div>
          </div>
          </div>


    @endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script src="{{ asset('js/tinymce.min.js') }}"></script>
    <script>
        tinymce.baseURL = '/tinymce';
        tinymce.init({
            selector: 'textarea#tinymce',
            width: '100%',
            height: 500, directionality :"rtl"
        });
        
        $('.select2.categories').select2({
            placeholder: 'إختر قسم',
            ajax: {
                url: '/admin/categories',
                dataType: 'json',
                processResults: function(data){
                    data = data.data;
                    var res = [];
                    for(var one in data){
                        res.push({
                            id: data[one].id,
                            text: data[one].name
                        });
                    }
                    return {
                        results: res
                    };
                }
            }
        });
        $('.select2.tags').select2({
            tags: true,
            placeholder: 'إختر وسم',
            insertTag: function(params){
                return params;
            },
            ajax: {
                url: '/admin/tags',
                dataType: 'json',
                processResults: function(data){
                    data = data.data;
                    var res = [];
                    for(var one in data){
                        res.push({
                            id: data[one].id,
                            text: data[one].name
                        });
                    }
                    return {
                        results: res
                    };
                }
            }
        });
    </script>
@endsection



