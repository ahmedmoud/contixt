@php
    $isEdit = @$update ? true : false;
@endphp
@extends('admin.master')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
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
           {{ __('admin.update') }} : {{ $post->title }} 
      </h4>
      @if( isset($Success) && $Success )
      {{ $Success }}
      @endif
      <br/>
      @if($errors->first('content'))
                	<div class="red-feedback">{{ $errors->first('content') }}</div>
            @endif
   
      <br/>
      <form autocomplete="off" class="form-horizontal m-t-40" method="POST" action="@if($isEdit){{ url('admin/future-updates/'.$update->id.'/edit') }}@else{{ url('admin/future-updates/'.$post->id.'/new') }}@endif?ash=yes" enctype="multipart/form-data" >
        @csrf
              @method('POST')
 
          <div class="form-group">
            <label for="title">{{ __('admin.title') }} *  <span id="titleCounter"></span></label>
            <div class="input-group mb-3">
                <input required value="{{ old('title') ? old('title') : ($isEdit ? @$update->title : '') }}" type="text" class="@if($errors->has('title')) is-invalid @endif form-control" placeholder="{{ __('admin.title') }}" name="title">
                @if($errors->has('title'))
                	<div class="red-feedback">{{ $errors->first('title') }}</div>
                	@endif
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
               <textarea  id="tinymce"  class="@if($errors->has('title')) is-invalid @endif form-control" rows="5" name="content" >{{  old('content') ? old('content') : ($isEdit ? @$update->content : $post->content )  }}</textarea>
               
            </div>
          </div>

          @stack('media-styles')
          @stack('media-scripts')

          <div class="form-group">
                <label class="m-t-40">{{ __('admin.date_time_post') }}</label>
                <input required type="text" id="date-time-format" class="form-control" placeholder="Now" name="date" value="{{ old('date') ? \Carbon\Carbon::now()  : old('date') ? old('date') : ($isEdit ? $update->date : \Carbon\Carbon::now() ) }}">
              </div>

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
        
        

        
    </script>
@endsection



