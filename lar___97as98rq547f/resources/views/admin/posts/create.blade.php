@php
    $isEdit = @$post ? true : false;
@endphp
@extends('admin.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link href="{{ asset('admin_panel/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_panel/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_panel/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_panel/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
<style> .red-feedback { background: red; color: #fff; padding: 7px; font-weight: bold; border-radius: 4px; margin: 5px 0; } .green-feedback { background: green; color: #fff; padding: 7px; font-weight: bold; border-radius: 4px; margin: 5px 0; } 
.without_ampm{ direction: rtl; text-align: right;padding-right:25px !important; }
.without_ampm::-webkit-datetime-edit-ampm-field { display: none; }
input[type=time].without_ampm::-webkit-clear-button { -webkit-appearance: none; -moz-appearance: none; -o-appearance: none; -ms-appearance:none; appearance: none; margin: -10px; }
input[type=time]::-webkit-inner-spin-button, input[type=time]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice {background: #00c292;}
.RelatedPostsBlock { background: #f1f1f1; padding: 15px; }
.relatedBlock { margin-top: 9px; line-height: 32px; padding: 4px; } .relatedBlock:nth-child(odd) { background: #dddddd; } .relatedBlock p { margin: 0; }
.relatedBlock a.removeRelatedBlock i { background: red; padding: 6px; border-radius: 4px; color: #fff; cursor: pointer; }
ul#RelatedPostsAjax { clear: both; float: none; max-width: 93%; display: block; margin-right: 25px; max-height: 321px; overflow-y: scroll; margin-top: 12px; flex: none; direction: rtl; background: #f1f1f1; padding: 5px; padding-right: 29px; }ul#RelatedPostsAjax li {cursor: pointer;color: #d40808;} ul#RelatedPostsAjax li:hover { color: green; }
 .activeLi { color: green !important; }
 .RelatedSearchBox { position:relative; padding:0 !important; margin: 0 5px; } .RelatedSearchBox.loading::before { content: ''; position:absolute; background: url('https://www.setaat.com/images/loader.gif'); left: 0; top: -1px; width: 39px; height: 39px; background-repeat: no-repeat; background-size: contain; }
 li.OldLi { color: #000 !important; }
 ul#choosedKws li { background: #ece9e9; display: block; margin-bottom: 5px; padding-right: 8px; cursor: pointer; } ul#choosedKws { width: 100%; padding: 4px; margin: 7px; } ul#choosedKws li span { color: red; margin-left: 12px; padding-right: 5px; }
</style>
<script>
    var mainURL = '{{ url('/') }}';
</script>
    @include('media::modal')
  <div class="col-lg-12" >
   <div class="card">
      <div class="card-body">
      <h4 class="card-title" style=" text-align: center; color: #4f5467; ">
          @if($isEdit)
              {{ __('admin.edit') }}
          @else
          {{ __('admin.add') }}
          @endif
          {{ __('admin.post') }}
      </h4>
      @if( isset($Success) && $Success )
      {{ $Success }}
      @endif
      <br/>
      @if( $isEdit ) <p style="  text-transform: capitalize;
      ">الكاتب : <b>{{ $post->author->name }}</b></p> @endif
      <br/>
      @if($errors->first('content'))
                	<div class="red-feedback">{{ $errors->first('content') }}</div>
            @endif
            <br/>
    @if($isEdit && $post->notes )

      @php 
            $post->notes = json_decode($post->notes);
      @endphp
      @if(  $post->notes->length ) <b>عدد الكلمات المطلوبة : </b>{{  $post->notes->length }} كلمة @endif
      @if(  $post->notes->notes ) <b>ملاحظات: </b>{{  $post->notes->notes }}  @endif
    @endif
      @if($isEdit && $SEOAgent)
      <p style=" font-size: 20px; font-weight: bold; color: red; ">مشاكل OnPage </p>
      {!! $SEOAgent !!}
      @endif
      <br/>

      <div class="modal fade bs-example-modal-lg" data-target-id="" tabindex="-1" id="RelatedPostsModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" alt-url="https://www.setaat.com/admin/media/ajaxSaveAlt">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myLargeModalLabel">إضافة مقالات متعلقة </h4> </div>
        <div class="modal-body">
        
            <div class="row">
<div class="col-md-12"><input type="text" class="form-control" placeholder="النص" id="RelatedText" data-role="tagsinput"  /> <br/></div>
<div class="col-md-10 RelatedSearchBox"><input type="text" class="form-control" placeholder="ابحث هنا عن المقال" id="RelatedSearchBox"  /> </div> 
<div class="col-md-1"><button type="button" class="btn" onclick="searchAllPosts();">بحث</button></div>
<ul id="choosedKws">
</ul>
        
     
                <ul id="RelatedPostsAjax" class="col-md-12"></ul>
      
        </div>
                
        </div> 
        <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="addNewRelatedBlock();" >إضافة</button>
        </div>
        </div>
         
        </div>
        
        </div>

      <form autocomplete="off" class="form-horizontal m-t-40" method="POST" action="@if($isEdit){{ url('admin/posts/'.$post->id) }}@else{{ url('admin/posts') }}@endif" enctype="multipart/form-data" >
        @csrf
          @if($isEdit)
              @method('PUT')
          @else
              @method('POST')
          @endif
          
          <div class="form-group">
            <label for="title">{{ __('admin.title') }} *  <span id="titleCounter"></span> ( ادخل عنوان مناسب يحتوي على الكلمة الدلالية )</label>
            <div class="input-group mb-3">
                <input required value="{{ old('title') ? old('title') : ($isEdit ? @$post->title : '') }}" type="text" class="@if($errors->has('title')) is-invalid @endif form-control" placeholder="{{ __('admin.title') }}" name="title">
                @if($errors->has('title'))
                	<div class="red-feedback">{{ $errors->first('title') }}</div>
                	@endif
            </div>
          </div>
          <div class="form-group">
            <label for="title"> {{ __('admin.slug') }} ({{ __('admin.slug_example') }})</label>
            <div class="input-group mb-3">

                <input value="{{ old('slug') ? old('slug') :  ($isEdit ? @trim(urldecode($post->slug)) : '') }}" type="text" class="@if($errors->has('slug')) is-invalid @endif form-control" placeholder="{{ __('admin.slug') }}" aria-label="Username" aria-describedby="basic-addon1" name="slug" id="slug" @if( $isEdit && !UPerm::EditPostSlug() ) disabled @endif >
                @if($errors->has('slug'))
                  <div class="red-feedback">{{ $errors->first('slug') }}</div>
                  @endif
            </div>
        </div>

        <div class="form-group">
            <label for="title"><mark style="background:#ffff00;"> {{ __('admin.focuskw') }} </mark></label>
            <div class="input-group mb-3">
                <input value="{{ old('focuskw') ? old('focuskw') :  ($isEdit ? @trim(urldecode($post->focuskw)) : '') }}" type="text" class="@if($errors->has('focuskw')) is-invalid @endif form-control" placeholder="{{ __('admin.focuskw') }}" aria-label="focuskw" aria-describedby="basic-addon1" name="focuskw" id="slug">
                @if($errors->has('focuskw'))
                  <div class="red-feedback">{{ $errors->first('focuskw') }}</div>
                  @endif
            </div>
        </div>

        <div class="form-group">
              <label for="title">{{ __('admin.stauts') }} *</label>
              <div class="input-group mb-3">
    @if( UPerm::PostPublish() || $post->status == 1 )
<label for="fstatus"> <input id="fstatus" required type="radio" name="status" value="1" @if(old('status') && old('status') == 1) checked @elseif($isEdit) @if($post->status && $post->status == 1 ) checked @endif @endif /> {{ __('admin.publish') }}</label>
    @endif
     @if( UPerm::PostPending() || $post->status == 2)
<label for="sstatus"> <input id="sstatus" required type="radio" name="status" value="2" @if(old('status') && old('status') == 2) checked @elseif($isEdit) @if($post->status && $post->status == 2 ) checked @endif @endif/> {{ __('admin.revision') }}</label>
    @endif
    <label for="tstatus"> <input id="tstatus" required type="radio" name="status" value="3" @if(old('status') && old('status') == 3) checked @elseif($isEdit) @if($post->status && $post->status == 3 ) checked @endif @endif {{ !$isEdit ? 'checked' : '' }} />{{ __('admin.draft') }}</label>

    @if( UPerm::PostReviewB4Publish() || ( $isEdit && $post->status == 4 ) )
<label for="dtstatus"> <input id="dtstatus" required type="radio" name="status" value="4" @if(old('status') && old('status') == 4) checked @elseif($isEdit) @if($post->status && $post->status == 4 ) checked @endif @endif />{{ __('admin.reviewd_b4_publish') }}</label>
@endif
              </div>
          </div>
          
        
          <div class="form-group">
              <label for="title">{{ __('admin.type') }} *</label>
              
              <div class="input-group mb-3">
                  
<label for="fstatus"> <input id="fstatus" required type="radio" name="type" value="post" required @if(old('type') && old('type') == 'post' ) checked @elseif($isEdit) @if($post->type && $post->type == 'post' ) checked @endif @endif {{ !$isEdit ? 'checked' : '' }} /> {{ __('admin.post') }} </label>

<label style="margin-right:9px;" for="fstatus"> <input id="fstatus" required type="radio" required name="type" value="video" @if(old('type') && old('type') == 'video' ) checked @elseif($isEdit) @if($post->type && $post->type == 'video' ) checked @endif @endif/> {{ __('admin.video') }} </label>
</div>
</div>
@if(  $isEdit && $post->recipe )
<style> #show_recipe { display:none;background: #ecf0f4;padding: 11px; }</style>
<div class="form-group">
    <input id="is_recipe" type="hidden" name="is_recipe" value="{{ old('is_recipe') || ( $isEdit && $post->recipe ) ? '1' : '' }}"  class="js-switch" data-color="#00c292"  />
    <label for="is_recipe" style=" font-size: 20px; color: #00c292; display:none;">وصفة ؟</label>
    <div class="form-group" id="show_recipe" @if( old('is_recipe') || (  $isEdit && $post->recipe ) )style="display:block;"@endif>
        <input type="text"  required class="form-control abcd" placeholder="اسم الوصفة" name="recipeName" value="{{ old('recipeName') ? old('recipeName') :  ($isEdit ? @trim($post->recipe->recipeName) : '') }}" />
<br/>
        {{-- <button type="button" class="btn btn-danger" id="SetWasfaaLogic">تحديث الحقول للوصفة</button> <br/> --}}
           <label for="ingredient">المقادير ( كل مقدار في سطر )</label>
            <div class="input-group mb-3">
               <textarea   required placeholder='المقادير' style=" width: 100%; border-radius: 5px; margin-top: 4px; " class="form-control abcd" rows="5" name="ingredient" id="ingredient">{{  old('ingredient') ? strip_tags( old('ingredient') ) : ($isEdit ? @$post->recipe->ingredient : '')  }}</textarea>
            </div>
            <label for="instructions">طريقة التحضير ( كل خطوة في سطر )</label>
            <div class="input-group mb-3">
               <textarea   required placeholder='الخطوات' style=" width: 100%; border-radius: 5px; margin-top: 4px; " class="form-control abcd" rows="5" name="instructions" id="instructions">{{  old('instructions') ? strip_tags( old('instructions') ) : ($isEdit ? @$post->recipe->instructions : '')  }}</textarea>
            </div>
            <label for="instructions">السعرات الحرارية ( رقم فقط ) لكل 250 جرام</label>
            <div class="input-group mb-3">
                    <input   value="{{ old('calories') ? old('calories') :  ($isEdit ? @trim($post->recipe->calories) : '') }}" type="number" class=" abcd @if($errors->has('calories')) is-invalid @endif form-control" placeholder="calories" aria-label="calories" aria-describedby="basic-addon1" name="calories" id="calories">
                    @if($errors->has('calories'))
                      <div class="red-feedback">{{ $errors->first('calories') }}</div>
                      @endif
                </div>

                <label for="instructions">محتوى الدهون ( رقم فقط  ) لكل 250 جرام</label>
                <div class="input-group mb-3">
                        <input   value="{{ old('fatContent') ? old('fatContent') :  ($isEdit ? @trim($post->recipe->fatContent) : '') }}" type="number" class=" abcd @if($errors->has('fatContent')) is-invalid @endif form-control" placeholder="محتوى الدهون" aria-label="fatContent" aria-describedby="basic-addon1" name="fatContent" id="fatContent">
                        @if($errors->has('fatContent'))
                          <div class="red-feedback">{{ $errors->first('fatContent') }}</div>
                          @endif
                    </div>
                    
                    <label for="instructions">البروتين ( رقم فقط  ) لكل 250 جرام</label>
                    <div class="input-group mb-3">
                            <input   value="{{ old('protein') ? old('protein') :  ($isEdit ? @trim($post->recipe->protein) : '') }}" type="number" class=" abcd @if($errors->has('protein')) is-invalid @endif form-control" placeholder="البروتين" aria-label="protein" aria-describedby="basic-addon1" name="protein" id="protein">
                            @if($errors->has('protein'))
                              <div class="red-feedback">{{ $errors->first('protein') }}</div>
                              @endif
                        </div>
                        <label for="instructions">كربوهيدرات ( رقم فقط  ) لكل 250 جرام</label>
                        <div class="input-group mb-3">
                                <input   value="{{ old('carbohydrates') ? old('carbohydrates') :  ($isEdit ? @trim($post->recipe->carbohydrates) : '') }}" type="number" class=" abcd @if($errors->has('carbohydrates')) is-invalid @endif form-control" placeholder="البروتين" aria-label="carbohydrates" aria-describedby="basic-addon1" name="carbohydrates" id="carbohydrates">
                                @if($errors->has('carbohydrates'))
                                  <div class="red-feedback">{{ $errors->first('carbohydrates') }}</div>
                                  @endif
                        </div>
                    
                <label for="prepTime">وقت التحضير ( مثال: 01:15 ، 00:15 )</label>
                <div class="input-group ">
                        <input   id="prepTime" data-default="00:00"  name="prepTime" class=" abcd form-control without_ampm" placeholder="00:00" value="{{  old('prepTime') ?  old('prepTime')  : ($isEdit ? @$post->recipe->prepTime : '00:00')  }}" />
                </div>
  
                <label for="cookTime">وقت الطبخ ( مثال: 01:15 ، 00:15 )</label>
                <div class="input-group ">
                         <input   id="cookTime" data-default="00:00" name="cookTime" class=" abcd form-control without_ampm" placeholder="00:00" value="{{  old('cookTime') ?  old('cookTime')  : ($isEdit ? @$post->recipe->cookTime : '00:00')  }}" />
                </div>
               @php $recipes_Types =  $post->recipe->types()->pluck('id')->toArray(); @endphp
                <label for="cuisine">المطبخ ( شرقي - غربي ....)</label>
                <div class="input-group ">
                   
                    <select   name="cuisine[]" class=" abcd form-control select22" multiple>
                    @foreach( $recipesTypes as $rtype )
                    @if( $rtype->type != 'cuisine' ) @continue @endif 
                        <option {{ $isEdit && in_array($rtype->id, $recipes_Types ) ? 'selected' : '' }} {{ ( old('cuisine') && old('cuisine') == $rtype->name )   ? 'selected' : '' }} value="{{ $rtype->id }}">{{ $rtype->name }}</option>
                    @endforeach
                    </select> 
                        </div>

                <label for="recipeType">نوع الوصفة ( مثال: حلويات )</label> 
                <div class="input-group ">
                    <select   name="recipeType[]" class=" abcd form-control select22" multiple>
                        @foreach( $recipesTypes as $rtype )
                        @if( $rtype->type != 'normalTypes' ) @continue @endif 
                        <option {{ $isEdit && in_array($rtype->id, $recipes_Types ) ? 'selected' : '' }} {{ ( old('recipeType') && old('recipeType') == $rtype->id )   ? 'selected' : '' }} value="{{ $rtype->id }}">{{ $rtype->name }}</option>
                       @endforeach
                    </select>
                </div>
                <label for="yield">تقدم لـ ( عدد الأفراد )</label>
                <div class="input-group ">
                    <select   name="yield" class=" abcd form-control">
                        @foreach( range(1,20) as $n )
                           <option {{ $isEdit && in_array($rtype->id, $recipes_Types ) ? 'selected' : '' }} {{  ( old('yield') && old('yield') == $n) || ( $isEdit && $post->recipe && $post->recipe->yield == $n )  ? 'selected' : '' }} value="{{ $n }} {{ $n > 2? 'أفراد' : 'فرد' }}">{{ $n }} {{ $n > 2? 'أفراد' : 'فرد' }}</option>
                        @endforeach
                    </select>
                        </div>
                        <label for="cookMethod">طريقة الطبخ المستخدمه</label>
                        <div class="input-group ">
                            <select  name="cookMethod[]" class=" abcd form-control select22" multiple>
                                @foreach( $recipesTypes as $rtype )
                                @if( $rtype->type != 'cookMethod' ) @continue @endif 
                                <option {{ $isEdit && in_array($rtype->id, $recipes_Types ) ? 'selected' : '' }} {{ ( old('cookMethod') && old('cookMethod') == $rtype->name )  ? 'selected' : '' }} value="{{ $rtype->id }}">{{ $rtype->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="diet">نوع الدايت</label>
                        <div class="input-group ">
                                <select name="diet" class=" abcd form-control select22" >
                                    @foreach( ["DiabeticDiet","GlutenFreeDiet","HalalDiet","HinduDiet","KosherDiet","LowCalorieDiet","LowFatDiet","LowLactoseDiet","LowSaltDiet","VeganDiet","VegetarianDiet"] as $cs )
                                    <option {{ ( old('diet') && old('diet') == $cs ) || ( $isEdit && $post->recipe && $post->recipe->diet == $cs )  ? 'selected' : '' }} value="{{ $cs }}">{{ $cs }}</option>
                                    @endforeach
                                </select>
                        </div>

                        <label for="diet">متوسط التكلفة</label>
                            <div class="input-group ">
                                <select  name="cost" class=" abcd form-control select22" >
                                    @foreach( $recipesTypes as $rtype )
                                    @if( $rtype->type != 'cost' ) @continue @endif 
                                    <option {{ $isEdit && in_array($rtype->id, $recipes_Types ) ? 'selected' : '' }} {{ ( old('cost') && old('cost') == $rtype->id )   ? 'selected' : '' }} value="{{ $rtype->id }}">{{ $rtype->name }}</option>
                                   @endforeach
                                </select>
                            </div>
<br/>
                        <label for="difficulty">الصعوبه</label>
                        <div class="input-group "> 
                            <select name="difficulty" class="form-control  abcd " >
                                @foreach( ["e"=>"سهل","m"=>"متوسط","d"=>"صعب"] as $key=>$cs )
                                <option {{ ( old('difficulty') && old('difficulty') == $key ) || ( $isEdit && $post->recipe && $post->recipe->difficulty == $key )  ? 'selected' : '' }} value="{{ $key }}">{{ $cs }}</option>
                                @endforeach
                            </select>
                        </div>
<br/>
<div class="form-group">
    <label for="notice">ملاحظات</label>
    <div class="input-group mb-3">
       <textarea  placeholder='ملاحظات عن الوصفه' style=" width: 100%; border-radius: 5px; margin-top: 4px; " class="form-control" rows="5" name="notice" id="notice">{{  old('notice') ? strip_tags( old('notice') ) : ($isEdit ? @$post->recipe->notice : '')  }}</textarea>
       @if($errors->has('notice'))
            <div class="red-feedback">{{ $errors->first('notice') }}</div>
            @endif
    </div>
  </div>

  @php
  $args = [
    'Mid' => 'mid_img',
          'Mtitle' =>  'صورة داخل المحتوى' ,
          'Mtype' => 0
  ];
//   if($isEdit && $post->recipe && $post->recipe->mid_img){
//       $args['currentValues'] = $post->recipe->mid_img;
//   }
if($isEdit && $post->recipe && $post->recipe->mid_img){
                $args['currentValues'] = $post->recipe->mid_img && !empty($post->recipe->mid_img) ? explode(",", $post->recipe->mid_img) : [];
            }
            
@endphp
@include('media::btn',$args)
<br/>
                            
                        <label for="videoURL">رابط الفيديو</label>
                        <div class="input-group ">
                                <input value="{{ old('videoURL') ? old('videoURL') :  ($isEdit ? @trim($post->recipe->videoURL) : '') }}" type="text" class="@if($errors->has('videoURL')) is-invalid @endif form-control" placeholder="videoURL" aria-label="videoURL" aria-describedby="basic-addon1" name="videoURL" id="videoURL">
                        </div> 
                        <br/>
                        
                        @php
                            $args = [
                                'Mid' => 'VideoThumbnail',
                                'Mtitle' =>  'Video Thumbnail' 
                            ];
                            if($isEdit && $post->recipe && $post->recipe->videoThumbnail){
                                $args['currentValues'] = $post->recipe->videoThumbnail;
                            }
                    @endphp
                  @include('media::btn',$args)


    </div>
</div>

@endif

@if( ($isEdit && !$post->recipe) || ( old('is_recipe') && old('is_recipe') != '1' ) || !$isEdit && !old('is_recipe') )

@include('media::btn',['Mid'=>'ffeature_imagee','Mtitle'=>  __('admin.insert_img_content') ,'Mtiny'=>'mymce','Mtype'=>1])
          <div class="form-group" id="contentBlock">
            <label for="tinymce"> {{ __('admin.post_content') }} *</label>
            <div class="input-group mb-3">
            @if($errors->has('content'))
                	<div class="red-feedback">{{ $errors->first('content') }}</div>
            @endif
                <div id="tempCountDiv" style="display:none;height:0;width:0;"></div>
                <span id="artWords" style="color:red" ></span>
               <textarea  id="tinymce"  class="@if($errors->has('title')) is-invalid @endif form-control" rows="5" name="content" >{{  old('content') ? old('content') : ($isEdit ? @$post->content : '')  }}</textarea>
               
            </div>
          </div>
          @endif

@if( !$isEdit || !( $isEdit && $post->recipe ) )     
          <div class="form-group">
            <label for="excerpt">{{ __('admin.short_desc') }} <span id="excerptCounter"></span></label>
            <div class="input-group mb-3">
               <textarea   placeholder='وصف قصير للمقال يحتوى على كلمات البحث ولا يزيد عن 160 حرف...' style=" width: 100%; border-radius: 5px; margin-top: 4px; " class="form-control" rows="5" name="excerpt" id="excerpt">{{  old('excerpt') ? strip_tags( old('excerpt') ) : ($isEdit ? @$post->excerpt : '')  }}</textarea>
               @if($errors->has('content'))
                	<div class="red-feedback">{{ $errors->first('excerpt') }}</div>
                	@endif
            </div>
          </div>
@endif








<script>
    function searchAllPosts(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var query = $('#RelatedSearchBox').val();
        $('.RelatedSearchBox').addClass('loading');
        $('#RelatedPostsAjax li').remove();
        $.ajax({
            type: 'post',
            url: '{{ url("/admin/ajaxPosts") }}',
            data: {
                "_token": "{{ csrf_token() }}",
                text: query
            },
            success: function(data){
                var thePushed = '';
                var OldrIDs = [];
                $('input.relatedPID').each(function(){
                    OldrIDs.push( $(this).val() );
                });
                console.log( OldrIDs );
                for(var i = 0; i<data.length; i++){
                    var addedClass = '';
                    if( OldrIDs.includes(data[i].id.toString() ) ){
                        addedClass = 'OldLi';
                    }
                    thePushed += "<li data-id='"+data[i].id+"' data-title='"+data[i].title+"' data-slug='"+data[i].slug+"' class='"+addedClass+"' >"+data[i].title+"</li>";
                }
                $('#RelatedPostsAjax').append(thePushed);
                $('.RelatedSearchBox').removeClass('loading');
            }
        }); 
 
        return false;
    }

    function addNewRelatedBlock(){
        var RelatedText = $('#RelatedText').val();
        RelatedText = RelatedText.split(',');
        var choosenPosts = $('#choosedKws li');

        if( RelatedText.length != choosenPosts.length ){
            alert('يجب أن يكون عدد المقالات المختارة == النصوص المضافة');
            return false;
        }       
        var key = 0;
        choosenPosts.each(function(){ 
            
        var rtitle = $(this).attr('data-title');
        var rid = $(this).attr('data-id');
        var rslug = $(this).attr('data-slug');


        var rOrder = $('.relatedBlock').length;
var endLoop = false;
        if( rOrder > 0 ){
            console.log('rorder');
            $('input.relatedPID').each(function(){
                if( $(this).val() == rid ){
                    alert('تم استخدام هذا الرابط من قبل');
                    endLoop = true;
                    return false;
                }
            });
        }
        if( endLoop ){
            return false;
        }

        console.log( RelatedText );
        var rBlock = '<div class="relatedBlock row"> <a class="removeRelatedBlock col-md-1"><i class="fa fa-times"></i></a> <p class="col-md-5">'+RelatedText[key]+'</p> <p class="col-md-5"> <a href="https://www.setaat.com/'+rslug+'" target="_blank" >'+rtitle+'</a></p> <input type="hidden" name="RelatedPosts['+rOrder+'][id]" class="relatedPID" value="'+rid+'" /> <input type="hidden" name="RelatedPosts['+rOrder+'][text]" value="'+RelatedText[key]+'" /> </div>';
        
        $('.RelatedPostsBlock').append(rBlock);
        key++;
    });
        
        // $('#RelatedPostsAjax li.activeLi').addClass('OldLi');
        
        $("#RelatedPostsModal").removeClass("in");
        $(".modal-backdrop").remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        $("#RelatedPostsModal").hide();

        return false;
    }
</script>
          <div class="form-group RelatedPostsBlock">
            <div class="RelatedForm row">
                <div class="col-md-4">
                        <button type="button" class=" btn btn-setaat"  data-toggle="modal" data-target="#RelatedPostsModal" >إضافة مقالات متعلقة جديدة</button>
                </div>
            </div>

@if( $isEdit && $post->RelatedPosts )
            @php $c=0; $post->RelatedPosts = json_decode($post->RelatedPosts); @endphp
                @foreach( $post->RelatedPosts as $key=>$rPost )
                        @php $tempPost = \App\Post::select('title','slug')->whereIn('type', ['post','video'])->where('id',$rPost->id)->where('status',1)->first(); if(!$tempPost) continue;  @endphp
                        <div class="relatedBlock row"> <a  class="removeRelatedBlock col-md-1"><i class="fa fa-times"></i></a> <p class="col-md-5">{{ $rPost->text }}</p> <p class="col-md-5"> <a href="{{ url($tempPost->slug) }}" target="_blank">{{ $tempPost->title }}</a></p> <input type="hidden" name="RelatedPosts[{{ $c }}][text]" value="{{ $rPost->text }}"> <input type="hidden" name="RelatedPosts[{{ $c }}][id]" class="relatedPID"  value="{{ $rPost->id }}"> 
                        </div>
                        @php $c++; @endphp
                @endforeach
            @endif

          </div>
          

<?PHP /* ?>
      <div class="form-group">
      <label for="participants1">{{ __('admin.all_comments') }}</label>
        <input  @if(old('comment_status') && old('comment_status') == true) checked @elseif($isEdit) @if($post->comment_status) checked @endif @else checked  @endif type="checkbox" class="js-switch" data-color="#009efb" name="comment_status" />
      </div>
<?PHP */ ?>
<style>.bootstrap-tagsinput{width:100%}</style>
@if( !$isEdit || !( $isEdit && $post->recipe ) )   
      <div class="form-group">
          <label class="card-subtitle">{{ __('admin.tags') }}</label>
          <div class="tags-default" style="width:100%">
          
        <input type="text" class=" form-control" value="{{ old('tags') ? old('tags') :  ($isEdit ? @trim($post->Tags) : '') }}" data-role="tagsinput" placeholder="{{ __('admin.write_click_enter') }}" name="tags" /> </div>

          <?PHP /* ?>
              <select multiple name="tags[]" class="@if($errors->has('tags')) is-invalid @endif tags form-control select2">
                  @if($isEdit)
                      @foreach($post->tags()->get() as $tag)
                          <option value="{{ $tag->id }}" selected> {{ $tag->name }} </option>
                      @endforeach
                  @endif
              </select>
              <?PHP */ ?>
              @if($errors->has('tags'))
                <div class="red-feedback">{{ $errors->first('tags') }}</div>
              @endif
          </div>
@endif
       
<?PHP
if( $isEdit ){
$postCats = $post->categories()->select('id')->get();
$pp = [];
foreach( $postCats as $postCat ){ $pp[] = $postCat->id; }
}
$oldCatts = old('categories') ? old('categories') : false;
?>
      <div class="form-group">
          <label>{{ __('admin.categories') }} *</label>
          <select required  multiple name="categories[]" class="snew @if($errors->has('categories')) is-invalid @endif form-control select2">

              @foreach( \App\Category::select('id','name')->get() as $category )
                    <option value="{{ $category->id }}" 
                    @if( ( $isEdit && in_array($category->id, $pp) ) || ( $oldCatts && in_array($category->id, $oldCatts) ) ) selected @endif
                    >{{ $category->name }}</option>
              @endforeach
             
          </select>
          @if($errors->has('categories'))
            <div class="red-feedback">{{ $errors->first('categories') }}</div>
          @endif
       </div>



        <div class="form-group">
                @php
                    $args = [
                  'Mid' => 'image',
                  'Mtitle' =>  __('admin.featured_img').' * ' 
                  ];
                    if($isEdit){
                        $args['currentValues'] = $post->image;
                    }
                @endphp
              @include('media::btn',$args)
            @stack('media-styles')
            @stack('media-scripts')
        </div>
@can('schedule','posts') 
          <div class="form-group">
            <label class="m-t-40">{{ __('admin.date_time_post') }}</label>
            <input required type="text" id="date-time-format" class="form-control" placeholder="Now" name="created_at" value="{{ empty('created_at') ? \Carbon\Carbon::now()  : old('created_at') ? old('created_at') : ($isEdit ? $post->created_at : \Carbon\Carbon::now() ) }}">
          </div>
@endcan
          <br/>
        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">
            @if($isEdit)
               {{ __('admin.save') }}
            @else
            {{ __('admin.add_post') }}
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
          tinyMCE.PluginManager.add('stylebuttons', function(editor, url) {
    ['pre', 'p', 'code', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'].forEach(function(name){
        editor.addButton("style-" + name, {
            tooltip: "Toggle " + name,
            text: name.toUpperCase(),
            onClick: function() { editor.execCommand('mceToggleFormat', false, name); },
            onPostRender: function() {
                var self = this, setup = function() {
                    editor.formatter.formatChanged(name, function(state) {
                        self.active(state);
                    });
                };
                editor.formatter ? setup() : editor.on('init', setup);
            }
        })
    });
});

        tinymce.baseURL = '/tinymce';
        tinymce.suffix = '.min';
        tinymce.init({
            
            fontsize_formats: '8pt 10pt 11pt 12pt 13pt 14pt 18pt 24pt 36pt',
            selector: 'textarea#tinymce',
            paste_as_text: true,
             content_css : "{{ url('css/prev.css') }}" ,
            width: '100%',
            theme: 'modern',
            height: 500, directionality :"rtl",
plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor","link","paste","stylebuttons"
                ],

                toolbar: "insertfile | styleselect | bold italic blockquote | fontsizeselect strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview  fullpage | forecolor backcolor emoticons charmap table | undo redo | unlink link | style-p style-h1 style-h2 style-h3",

            relative_urls: false,
            convert_urls: false,
            remove_script_host : false,
            allow_script_urls: true,
           // link_list : "https://www.setaat.com/linklist",
                    setup : function(ed)
            {
                ed.on('init', function() 
                {
                    this.execCommand("fontSize", false, "11pt");
                     countWords();
                });
                 ed.on('keyup', function (e) {
                    countWords();
                });
                ed.on('change', function(e) {
                   countWords();
                });
            } 

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
            if( excerptLength > 160 ){
                $('#excerptCounter').css('color','red');
            }else{
                $('#excerptCounter').css('color','green');
            }
            $('#excerptCounter').html( $(this).val().length + ' حرف' );
        });
        $('input[name="title"]').keyup(function(){
            var excerptLength = $(this).val().length;
            if( excerptLength > 70 || excerptLength == 0 ){
                $('#titleCounter').css('color','red');
            }else{
                $('#titleCounter').css('color','green');
            }
            $('#titleCounter').html( $(this).val().length + ' حرف - بحد أقصى 70 حرف.' );
        });
        $(".snew").select2({});
        $(".select22").select2();
    </script>
         <script src="{{ asset('admin_panel/moment/moment.js') }}"></script>
     <script src="{{ asset('admin_panel/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
     <script src="{{ asset('admin_panel/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
     <script src="https://www.setaat.com/admin_panel/switchery/dist/switchery.min.js"></script>
<script>
    $(function () {
            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });
        });
    </script>
     <script>
    $('#date-time-format').bootstrapMaterialDatePicker({
         format: 'YYYY-MM-DD HH:mm:00' 
        });
        
        function countWords(){
           var  s = tinyMCE.get('tinymce').getContent();
            $('#tempCountDiv').html(s);
            
             s = $('#tempCountDiv').text();

             s = s.replace("&nbsp;",' ');
           ee = new RegExp(String.fromCharCode(160), "g");
			s = s.replace(ee, " ");

             s = s.replace("\n",' ');
             s = s.replace(/(?:\r\n|\r|\n|\.|،|_|-)/g, ' ');

             
            s = s.replace(/(^\s*)|(\s*$)/gi,"");//exclude  start and end white-space
            
            s = s.replace(/[ ]{2,}/gi," ");//2 or more space to 1
        	s = s.replace('.',' ');
        		
        	
            s = s.replace(/\n /,"\n"); // exclude newline with a start spacing
            var words =  s.split(' ').filter(function(str){return str!="";}).length;
            $('#artWords').html(words+' كلمة');
            //return s.split(' ').filter(String).length; - this can also be used
        }
        
        $('#is_recipe').on('change', function(){

            if( $('#is_recipe').prop('checked') ){
                $('#show_recipe').show();
                $('#contentBlock').hide();
                $(".select22").select2();
            }else{
                $('#show_recipe').hide();
                $('#contentBlock').show();
            }
        
        }); 

    $('#SetWasfaaLogic').click(function(){

        if( !$('select[name="cuisine[]"]').val()[0] ||  $('#cookTime').val() == '' || $('#cookTime').val() == '00:00'){
            alert('جيب اختيار اسم الوصفة بالإضافة الى وقت الطبخ');
            return false;
        }

        var keyword = $('input[name=recipeName]').val();
        var title = "طريقة عمل "+keyword;
        $('input[name=focuskw]').val(title);
        $('input[name=title]').val(title);
        $('input[name=slug]').val(title);
        $('input[name=tags]').val(title+","+keyword);
        $('input[name=tags]').tagsinput('destroy');
        $('input[name=tags]').tagsinput();

        var cookTime = $('#cookTime').val();
        cookTime = cookTime.split(':');
        cookTime = parseInt(cookTime[0]) * 60 + parseInt(cookTime[1]);

        var cuisine = $('select[name="cuisine[]"]').val()[0];
        $('#excerpt').val("بنقدملك طريقة عمل "+keyword+" الشهية من المطبخ "+cuisine+" بوصفة سهلة وتقدري تعمليها فى اقل من "+cookTime+" دقيقة. اعرفي مكونات ومقادير "+keyword+". جربيها وبالهنا والشفا");
        
    });

    var input = $('#prepTime,#cookTime');
        input.clockpicker({
            autoclose: true,
            align: 'right' 
        });
          
        $('body').on('click', 'ul#RelatedPostsAjax li', function(){
            var liHTML = $(this).prop('outerHTML');;
            var liTxt = $(this).text();
            var lidID = $(this).attr('data-id');
            var liSlug = $(this).attr('data-slug');

            $('ul#choosedKws').append(liHTML);
            $('ul#choosedKws').find('li[data-id="'+lidID+'"]').html("<span onclick='return this.parentNode.remove();' >X</span> <a target='_blank' href='"+liSlug+"'>"+liTxt+"</a>");
            $('ul#RelatedPostsAjax li').removeClass('activeLi');
            $(this).addClass('activeLi');
            $(this).remove();
        });



    $(document).keypress(function(event){
	
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13' && $('#RelatedSearchBox').is(':focus') ){
            searchAllPosts();
        }
      
	
    });
    $('body ').on('click', 'a.removeRelatedBlock', function(){
        $(this).parent().remove();
    });
    
    @if( Auth::user()->role->name != 'Admin' )

if( $('input#tstatus').prop('checked') ){
	$('#show_recipe').find('input,textarea,select').attr('required', false);
}

$('input[name="status"]').change(function(){
	if( this.value == '3' ){ 
			$('#show_recipe').find('.abcd').attr('required', false);
	 }else{
			$('#show_recipe').find('.abcd').attr('required', true);

     }

});
@endif

    </script>
@endsection



