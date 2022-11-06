@php
    $isEdit = @$post ? true : false;
@endphp
@extends('admin.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link href="{{ asset('admin_panel/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />

@endsection
@section('content')

<script>
    var mainURL = '{{ url('/') }}';
</script>

    @include('media::modal')
  <div class="col-lg-12" >
   <div class="card">
      <div class="card-body">
      <h4 class="card-title" style=" text-align: center; color: #4f5467; ">
          @if($isEdit)
              تعديل
          @else
              اضافة
          @endif
          مسابقة
      </h4>
      <form class="form-horizontal m-t-40" method="POST" action="@if($isEdit){{ url('admin/competitions/'.$post->id) }}@else{{ url('admin/competitions') }}@endif" enctype="multipart/form-data" >
        @csrf 
          @if($isEdit)
              @method('PUT')
          @else
              @method('POST')
          @endif
          
          <div class="form-group">
            <label for="title">عنوان *</label>
            <div class="input-group mb-3">
                <input required value="{{ old('title') ? old('title') : ($isEdit ? @$post->title : '') }}" type="text" class="@if($errors->has('title')) is-invalid @endif form-control" placeholder="عنوان" name="title">
                @if($errors->has('title'))
                	<div class="invalid-feedback">{{ $errors->first('title') }}</div>
                	@endif
            </div>
          </div>
          <div class="form-group">
              <label for="title"> الرابط (مثال: تجربة-مقال-جديد )</label>
              <div class="input-group mb-3">

                  <input value="{{ old('slug') ? old('slug') :  ($isEdit ? @trim(urldecode($post->slug)) : '') }}" type="text" class="@if($errors->has('slug')) is-invalid @endif form-control" placeholder="رابط" aria-label="Username" aria-describedby="basic-addon1" name="slug" id="slug">
                  @if($errors->has('slug'))
                	<div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                	@endif
              </div>
          </div>
          
          <div class="form-group">
              <label for="title">الحالة *</label>
              <div class="input-group mb-3">
    @if( UPerm::PostPublish() || $post->status == 1 )
<lable for="fstatus"> <input id="fstatus" required type="radio" name="status" value="1" @if(old('status') && old('status') == 1) checked @elseif($isEdit) @if($post->status && $post->status == 1 ) checked @endif @endif/> منشور</lable>
    @endif

<lable for="tstatus"> <input id="tstatus" required type="radio" name="status" value="2" @if(old('status') && old('status') == 2) checked @elseif($isEdit) @if($post->status && $post->status == 2 ) checked @endif @endif/> غير منشور</lable>
                 
              </div>
          </div>
          
                          @include('media::btn',['Mid'=>'ffeature_imagee','Mtitle'=>' إضافة صورة للمحتوى بالأسفل','Mtiny'=>'mymce','Mtype'=>1])

          <div class="form-group">
            <label for="tinymce">محتوى المسابقة *</label>
            <div class="input-group mb-3">
           
               <textarea  id="tinymce"  class="@if($errors->has('title')) is-invalid @endif form-control" rows="5" name="content" >{{  old('content') ? old('content') : ($isEdit ? @$post->content : '')  }}</textarea>
               @if($errors->has('content'))
                	<div class="invalid-feedback">{{ $errors->first('content') }}</div>
                	@endif
            </div>
          </div>
          
          <div class="form-group">
            <label for="excerpt">وصف قصير (المقتطف) <span id="excerptCounter"></span></label>
            <div class="input-group mb-3">
               <textarea  placeholder='وصف قصير للمسابقة يحتوى على كلمات البحث ولا يزيد عن 300 حرف...' style=" width: 100%; border-radius: 5px; margin-top: 4px; " "form-control" rows="5" name="excerpt" id="excerpt">{{  old('excerpt') ? old('content') : ($isEdit ? @$post->excerpt : '')  }}</textarea>
               @if($errors->has('content'))
                	<div class="invalid-feedback">{{ $errors->first('excerpt') }}</div>
                	@endif
            </div>
          </div>


{{--old('title')--}}

      <div class="form-group">
      <label for="participants1">السماح بالتعليقات</label>
        <input  @if(old('comment_status') && old('comment_status') == true) checked @elseif($isEdit) @if($post->comment_status) checked @endif @else checked  @endif type="checkbox" class="js-switch" data-color="#009efb" name="comment_status" value="1"/>
      </div>

        <div class="form-group">
                @php
                    $args = [
                  'Mid' => 'image',
                  'Mtitle' => 'صورة المسابقة *'
                  ];
                    if($isEdit){
                        $args['currentValues'] = $post->image;
                    }
                @endphp
              @include('media::btn',$args)
            @stack('media-styles')
            @stack('media-scripts')
        </div>

        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
            @if($isEdit)
                حفظ التعديل
            @else
                اضافة منشور
            @endif
        </button>
        
         </form>
          </div>
          </div>
          </div>


    @endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('admin_panel/bootstrap-tagsinput/src/bootstrap-tagsinput.min.js') }}"></script>

    <script src="{{ asset('js/tinymce.min.js') }}"></script>
    <script>
        tinymce.baseURL = '/tinymce';
        tinymce.suffix = '.min';
        tinymce.init({
            selector: 'textarea#tinymce',
             content_css : "{{ url('css/prev.css') }}" ,
            width: '100%',
            theme: 'modern',
            height: 500, directionality :"rtl",
plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic blockquote | fontsizeselect strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview media fullpage | forecolor backcolor emoticons  ",

            relative_urls: false,
            convert_urls: false,
            remove_script_host : false,
            allow_script_urls: true
        });
        
        $('.select2.categories').select2({
            placeholder: 'إختر قسم',
            ajax: {
                url: '/admin/categories/get',
                dataType: 'json',
                processResults: function(data){
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

        $('textarea[name="excerpt"]').keyup(function(){
            var excerptLength = $(this).val().length;
            if( excerptLength > 300 ){
                $('#excerptCounter').css('color','red');
            }else{
                $('#excerptCounter').css('color','green');
            }
            $('#excerptCounter').html( $(this).val().length + ' حرف' );
        });
    </script>
    
@endsection



