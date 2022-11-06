@php
    $isEdit = @$post ? true : false;
@endphp
@extends('admin.master')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link href="{{ asset('admin_panel/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_panel/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection
@section('content')
<style>
.red-feedback {
    background: red;
    color: #fff;
    padding: 7px;
    font-weight: bold;
    border-radius: 4px;
    margin: 5px 0;
}
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
      @if($errors->first('content'))
                	<div class="red-feedback">{{ $errors->first('content') }}</div>
            @endif

      @if($isEdit && $SEOAgent)
      <p style=" font-size: 20px; font-weight: bold; color: red; ">مشاكل OnPage </p>
      {!! $SEOAgent !!}
      @endif
      <br/>
      <form autocomplete="off" class="form-horizontal m-t-40" method="POST" action="@if($isEdit){{ url('admin/posts/'.$post->id) }}@else{{ url('admin/posts') }}@endif" enctype="multipart/form-data" >
        @csrf
          @if($isEdit)
              @method('PUT')
          @else
              @method('POST')
          @endif
          
          <div class="form-group">
            <label for="title">{{ __('admin.title') }} *</label>
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
<lable for="fstatus"> <input id="fstatus" required type="radio" name="status" value="1" @if(old('status') && old('status') == 1) checked @elseif($isEdit) @if($post->status && $post->status == 1 ) checked @endif @endif/> {{ __('admin.publish') }}</lable>
    @endif
     @if( UPerm::PostPending() || $post->status == 2)
<lablel for="sstatus"> <input id="sstatus" required type="radio" name="status" value="2" @if(old('status') && old('status') == 2) checked @elseif($isEdit) @if($post->status && $post->status == 2 ) checked @endif @endif/> {{ __('admin.revision') }}</lablel>
    @endif
<lablel for="tstatus"> <input id="tstatus" required type="radio" name="status" value="3" @if(old('status') && old('status') == 3) checked @elseif($isEdit) @if($post->status && $post->status == 3 ) checked @endif @endif/>{{ __('admin.draft') }}</lablel>
                 
              </div>
          </div>
          
          
          <div class="form-group">
              <label for="title">{{ __('admin.type') }} *</label>
              
              <div class="input-group mb-3">
                  
<lablel for="fstatus"> <input id="fstatus" required type="radio" name="type" value="post" required @if(old('type') && old('type') == 'post' ) checked @elseif($isEdit) @if($post->type && $post->type == 'post' ) checked @endif @endif/> {{ __('admin.post') }} </lable>

<lablel style="margin-right:9px;" for="fstatus"> <input id="fstatus" required type="radio" required name="type" value="video" @if(old('type') && old('type') == 'video' ) checked @elseif($isEdit) @if($post->type && $post->type == 'video' ) checked @endif @endif/> {{ __('admin.video') }} </lablel>


</div>
</div>


                          @include('media::btn',['Mid'=>'ffeature_imagee','Mtitle'=>  __('admin.insert_img_content') ,'Mtiny'=>'mymce','Mtype'=>1])

          <div class="form-group">
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

          <div class="form-group">
            <label for="excerpt">{{ __('admin.short_desc') }} <span id="excerptCounter"></span></label>
            <div class="input-group mb-3">
               <textarea  placeholder='وصف قصير للمقال يحتوى على كلمات البحث ولا يزيد عن 300 حرف...' style=" width: 100%; border-radius: 5px; margin-top: 4px; " "form-control" rows="5" name="excerpt" id="excerpt">{{  old('excerpt') ? strip_tags( old('excerpt') ) : ($isEdit ? @$post->excerpt : '')  }}</textarea>
               @if($errors->has('content'))
                	<div class="red-feedback">{{ $errors->first('excerpt') }}</div>
                	@endif
            </div>
          </div>


{{--old('title')--}}

      <div class="form-group">
      <label for="participants1">{{ __('admin.all_comments') }}</label>
        <input  @if(old('comment_status') && old('comment_status') == true) checked @elseif($isEdit) @if($post->comment_status) checked @endif @else checked  @endif type="checkbox" class="js-switch" data-color="#009efb" name="comment_status" />
      </div>
<style>.bootstrap-tagsinput{width:100%}</style>
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

       
<?PHP
if( $isEdit ){
$postCats = $post->categories()->select('id')->get();
$pp = [];
foreach( $postCats as $postCat ){ $pp[] = $postCat->id; }
}
?>
      <div class="form-group">
          <label>{{ __('admin.categories') }} *</label>
          <select required multiple name="categories[]" class="snew @if($errors->has('categories')) is-invalid @endif form-control select2">

              @foreach( \App\Category::select('id','name')->get() as $category )
                    <option value="{{ $category->id }}" 
                    @if($isEdit && in_array($category->id, $pp) ) selected @endif
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
            <input type="text" id="date-time-format" class="form-control" placeholder="Now" name="created_at" value="{{ empty('created_at') ? \Carbon\Carbon::now()  : old('created_at') ? old('created_at') : ($isEdit ? $post->created_at : \Carbon\Carbon::now() ) }}">
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

    tinyMCE.ui.Factory.add("LinkInput", tinyMCE.ui.Control.extend({
        renderHtml: function() {
            return '<div id="' + this._id + '" class="wp-link-input"><input type="text" value="" placeholder="' + tinyMCE.translate("Paste URL or type to search") + '" /><input type="text" style="display:none" value="" /></div>'
        },
        setURL: function(a) {
            this.getEl().firstChild.value = tinyMCE
        },
        getURL: function() {
            return a.trim(this.getEl().firstChild.value)
        },
        getLinkText: function() {
            var b = this.getEl().firstChild.nextSibling.value;
            return a.trim(b) ? b.replace(/[\r\n\t ]+/g, " ") : ""
        },
        reset: function() {
            var a = this.getEl().firstChild;
            a.value = "",
            a.nextSibling.value = ""
        }
    }));
    

        tinymce.baseURL = 'https://w3n3u4x5.stackpathcdn.com/tinymce';
        tinymce.suffix = '.min';
        tinymce.init({
            external_link_list_url : "myexternallist.js",
            fontsize_formats: '8pt 10pt 11pt 12pt 13pt 14pt 18pt 24pt 36pt',
            selector: 'textarea#tinymce',
            paste_as_text: true,
             content_css : "{{ url('css/prev.css') }}" ,
            width: '100%',
            theme: 'modern',
            height: 500, directionality :"rtl",
plugins: [
                    "advlist autolink image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor","link","paste","stylebuttons"
                ],
                link_list: [
        <?PHP
        $AllPosts = \App\Post::whereIn('posts.type',['video','post'])->where('posts.created_at','<=',  \Carbon\Carbon::now() )->where('posts.status', 1)->where('posts.lang', \App::getLocale() )->where('status',1)->select('posts.title','posts.slug' )->orderBy('posts.created_at','DESC')->groupBy('posts.id')->limit(1)->get();
        ?>
        @foreach( $AllPosts as $aPost ){title: '{{ $aPost->title }}', value: '{{ url($aPost->slug) }}'},@endforeach
    ],
                toolbar: "insertfile | styleselect | bold italic blockquote | fontsizeselect strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview  fullpage | forecolor backcolor emoticons charmap table | undo redo | unlink link | style-p style-h1 style-h2 style-h3 | LinkBTN",

            relative_urls: false,
            convert_urls: false,
            remove_script_host : false,
            allow_script_urls: true,
           // link_list : "https://www.setaat.com/linklist",
                    setup : function(ed)
            {
                
                  ed.addButton('LinkBTN', {
                  text: 'LinkInput',
                  icon: false,
                  onclick: function () {
                    ed.insertContent('&nbsp;<b>It\'s my button!</b>&nbsp;');
                  }
                });
    
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
            if( excerptLength > 300 ){
                $('#excerptCounter').css('color','red');
            }else{
                $('#excerptCounter').css('color','green');
            }
            $('#excerptCounter').html( $(this).val().length + ' حرف' );
        });
        $(".snew").select2({});
    </script>
         <script src="{{ asset('admin_panel/moment/moment.js') }}"></script>
     <script src="{{ asset('admin_panel/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
     <script>
    $('#date-time-format').bootstrapMaterialDatePicker({
         format: 'YYYY-MM-DD HH:mm:00' 
        });
        
        function countWords(){
           var  s = tinyMCE.get('tinymce').getContent();
            $('#tempCountDiv').html(s);
            
             s = $('#tempCountDiv').text();
             s = s.replace("\n",' ');
             s = s.replace(/(?:\r\n|\r|\n)/g, ' ');

             
            s = s.replace(/(^\s*)|(\s*$)/gi,"");//exclude  start and end white-space
            
            s = s.replace(/[ ]{2,}/gi," ");//2 or more space to 1
        	s = s.replace('.',' ');
        		
        	
            s = s.replace(/\n /,"\n"); // exclude newline with a start spacing
            var words =  s.split(' ').filter(function(str){return str!="";}).length;
            $('#artWords').html(words+' كلمة');
            //return s.split(' ').filter(String).length; - this can also be used
        }
        
        

        
    </script>
@endsection



