@extends('admin.master')
@section('title', 'Admin Categories')
@section('styles')
    <link href="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
.customc {
    background: #8080801f;
    padding: 7px;    margin-bottom: 7px;
}
.customc strong{
font-weight: bold;
}
li.select2-selection__choice { background: #00c292 !important; }
</style>
@endsection
@section('content')
 
		<div>
            @can('create', 'posts')
			    <a href="{{ url('admin/posts/create') }}" class="btn btn-primary" style="margin: 10px;">{{ __('admin.add_post') }}</a>
            @endcan
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
<form action="{{ url('admin/search-posts') }}">


<label > Filter Categories <input type="checkbox" @if( isset($_GET['filterCategories']) && $_GET['filterCategories'] ) checked @endif name="filterCategories" value="1" > </label>
<br/>

<div class="row m-t-40">
    <div class="col-md-2" >

        <select name="status" >
            <option value='' >{{ __('admin.all').' '.__('admin.status') }}</option>
            <option value="1" {{ ( isset($_GET['status']) && $_GET['status'] == 1 )? 'selected' : '' }}>{{ __('admin.publish') }}</option>
            <option value="2" {{ ( isset($_GET['status']) && $_GET['status'] == 2 )? 'selected' : '' }}>{{ __('admin.revision') }} </option>
            <option value="3" {{ ( isset($_GET['status']) && $_GET['status'] == 3 )? 'selected' : '' }}>{{ __('admin.draft') }}</option>
            <option value="4" {{ ( isset($_GET['status']) && $_GET['status'] == 4 )? 'selected' : '' }}>{{ __('admin.ready4Publish') }}</option>
            <option value="schedule" {{ ( isset($_GET['status']) && $_GET['status'] == 'schedule' )? 'selected' : '' }}>{{ __('admin.schedule') }}</option>
        </select>
    </div>

     <div class="col-md-6" >
        <select name="category[]" multiple="multiple" class="categorySelect">
        <option value='' >{{ __('admin.all').' '.__('admin.categories') }} </option>
            @foreach( $categories as $cat )
                <option @if( isset( $_GET['category'] ) &&  in_array($cat->id, $_GET['category']) ) selected="selected" @endif  value="{{ $cat->id }}">{{ $cat->name }} </option>
            @endforeach
        </select>
    </div>
 
    <div class="col-md-3">
        <select name="user">
        <option value=''>{{ __('admin.all').' '.__('admin.users') }}</option>
            @foreach( $users as $user )
                <option @if( isset( $_GET['user'] ) && $_GET['user'] == $user->id ) selected @endif value="{{ $user->id }}">{{ $user->id }} - {{ $user->name }} </option>
            @endforeach
        </select>
    </div>
<br/>
<div class="col-md-2" style=" margin: 20px 0; ">
            <select name="type">
            <option value='' > {{ __('admin.type') }} </option>
            <option value="post" {{ ( isset($_GET['type']) && $_GET['type'] == 'post' )? 'selected' : '' }}>{{ __('admin.post') }}</option>
            <option value="video" {{ ( isset($_GET['type']) && $_GET['type'] == 'video' )? 'selected' : '' }}>{{ __('admin.video') }}</option>
            <option value="resala" {{ ( isset($_GET['type']) && $_GET['type'] == 'resala' )? 'selected' : '' }}>{{ __('admin.resala') }}</option>
            <option value="keyword" {{ ( isset($_GET['type']) && $_GET['type'] == 'keyword' )? 'selected' : '' }}>Keyword</option>
        </select>
    </div>

<div class="col-md-2" style=" margin: 20px 0; ">
            <select name="onpage" >
            <option value='' > OnPage </option>
            <option value="bad" {{ ( isset($_GET['onpage']) && $_GET['onpage'] == 'bad' )? 'selected' : '' }}>Bad</option>
            <option value="good" {{ ( isset($_GET['onpage']) && $_GET['onpage'] == 'good' )? 'selected' : '' }}>Good</option>

        </select>
    </div>
    <br/>
    <div class="col-md-3">
        <input type="text" name="query" placeholder="{{ __('admin.search_here') }}" value="{{ ( isset($_GET['query']) )? $_GET['query'] : ''  }}" style="margin-top:15px;" />
    </div>
    <br/>
 <div class="col-md-4">
     <div class="example" style="margin-top:15px;">
            <div class="input-group">
                <input type="text" class="form-control mydatepicker" autocomplete="off" placeholder="{{ __('admin.date_starts_on') }}" name="dateTo" value="{{ ( isset($_GET['dateTo']) )? $_GET['dateTo'] : ''  }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="icon-calender"></i></span>
                </div>
            </div>
        </div>
</div>
 <div class="col-md-4">
         <div class="example" style="margin-top:15px;">
            <div class="input-group">
                <input type="text" class="form-control mydatepicker"  autocomplete="off"  placeholder="{{ __('admin.date_ends_on') }}" name="dateFrom" value="{{ ( isset($_GET['dateFrom']) )? $_GET['dateFrom'] : ''  }}">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="icon-calender"></i></span>
                </div>
            </div>
        </div>
</div>
<div class="col-md-3">
    <input type="text" name="paginate" placeholder="Posts/page (max:150)" value="{{ ( isset($_GET['paginate']) )? $_GET['paginate'] : ''  }}" style="margin-top:15px;text-align:center;" />
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <textarea placeholder="posts Ids - id/line" name="ids" id="" cols="60" rows="10" style=" margin-top: 9px; text-align:left;" >{{ ( isset($_GET['ids']) )? $_GET['ids'] : ''  }}</textarea>
    </div>
</div>

<button type="submit" class="btn btn-danger clearfix" style="float: none;margin: 20px auto;display: block;padding: 10px 44px;">{{ __('admin.search') }}</button>
@if( UPerm::ViewUsersLength() )
<button type="submit" name="wordsLength" value='1' class="btn btn-danger clearfix" style="float: none;margin: 20px auto;display: block;padding: 10px 44px;">عدد الكلمات</button>
@endif

</form>    

                </div>

@if( count($postsLengthes) > 0 && $lengthes )
            <p style="margin:auto; text-align:center;" > عدد الكلمات : {{ number_format($lengthes) }} </p>
@endif



@if( isset($posts) )
<p style="margin:auto; text-align:center;" >{{ __('admin.results_number') }} : {{ $posts->total() }}</p>

@if( isset($_GET['type']) && !empty($_GET['type']) )
<p style="margin:auto; text-align:center;" >{{ __('admin.type') }} : {{ $_GET['type'] == 'post' ? 'مقال' : 'رسالة' }}

@endif

@if( $categories__filtered )
<div class="container">
<div class="row">
    @php $abcd = 0; $abcde = 0;  @endphp
@foreach ($categories__filtered as $ccid=>$cfilter )
   @foreach( $categories as $ccat )
        @if( $ccat->id == $ccid )
        @php $abcd += $cfilter['words']; $abcde += count($cfilter['posts']); @endphp
            <div class="col-md-4 ">
                <div class="customc">
                   <strong> {{ $ccat->name }} - {{ $ccat->id }} </strong><br/>
                    Words: {{ $cfilter['words'] }}<br/>
                    Posts: {{ count($cfilter['posts']) }}<br/>
                    {{ implode(',', $cfilter['posts']) }}
                </div>
            </div>
        @endif
   @endforeach
@endforeach
</div></div>
{{ $abcd  .' - '. $abcde }}
@endif
               @include('admin.posts.loopTable');
@endif
		</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script src="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
     <script>
     // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    $('select').not('.not-select2,.categorySelect').select2();

    $('select.categorySelect').select2({ placeholder:'القسم'});
    </script>


@endsection