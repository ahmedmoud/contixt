@extends('admin.master')
@section('title', 'Admin Categories')
@section('styles')
    <link href="{{ asset('admin_panel/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

@endsection
@section('content')
 
<style>.asdfasd a{ width: 100%; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: pre-wrap; display: inline-block; border: 0; min-width: 203px;} .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; }
.rota { transform: rotate(-90deg); float: left; border-right: 0; border-left: 0; position: relative; display: inline; text-align: center; width: 11px; top: -26px; font-weight: bold; height: 44px; left: 11px; } span.good { display: block; width: 20px; height: 20px; background: #00c206; border-radius: 50%; text-align: center; margin: auto; } span.bad { display: inline-block; width: 20px; height: 20px; background: #f70303; border-radius: 50%; text-align: center; margin: auto; bottom:-4px; position:relative; } .red-feedback { background: red; color: #fff; padding: 7px; font-weight: bold; border-radius: 4px; margin: 5px 0; }
.green-feedback { background: green; color: #fff; padding: 7px; font-weight: bold; border-radius: 4px; margin: 5px 0; }
input.bulkBox, input.checkAll { width: 20px; height: 20px; }
</style>
   
<div class="table-responsive m-t-40">
        <p style=" text-align: center; font-weight: bold; font-size: 16px; "> مجرد الضغط على "بدء الكتابة" يصبح الموضوع خاص بك </p>
        

<form action="{{ route('KeywordSearch') }}" method="GET" >
    <div class="row" >
    <div class="col-md-4" >
        <input type="text" name="s" placeholder="ابحث هنا" value="{{ old('s') ? old('s') : ( isset($_GET['s']) ? trim($_GET['s']) : '' ) }}"/>
    </div>
    <div class="col-md-4" >
    <select  multiple name="c[]" class="snew @if($errors->has('categories')) is-invalid @endif form-control select2">

        @foreach( \App\Category::select('id','name')->get() as $category )
            <option value="{{ $category->id }}" 
            @if(  old('c') && in_array( $category->id, old('c') ) || ( isset($_GET['c']) && is_array($_GET['c']) && in_array($category->id, $_GET['c']) ) ) selected @endif
            >{{ $category->name }}</option>
        @endforeach
    
    </select>
</div>   
<div class="col-md-3" >
<button class="btn btn-danger" type="submit" >بحث</button>
</div>
</div>
</form>
<br/>



@if( $errors->first('bulkOverflow')  )
    <div class="green-feedback">{!! $errors->first() !!}</div> 
@endif

        @if( $errors->first('manyKeywords') || $newKeywords == 'disabled' )
            <div class="red-feedback">يجب أن يكون لديك أقل من 10 مقالات في المسودات لحجز كلمات  دلالية جديدة</div>
        @endif
        
    <form action="{{ route('keywordsBulkAction') }}" method="POST" id="bulkActionForm" >
        @csrf
        <input type="hidden" name="bulkKeywords" class="bulkKeywords" />
        <button type="button" id="bulkFormBTN" class="btn btn-setaat " > بدء الكتابة </button>
    </form>
    <br/>

<table id="example23" class="display nowrap table table-hover table-striped table-bordered bulkedTable" cellspacing="0" widtd="100%">
<thead>
<tr>
    <th><input type="checkbox" class="checkAll" /></th>
    <th>الكلمة الدلالية</th>
    <th>العنوان</th>
    <th>عدد الكلمات</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($posts as $post)
<tr>
<td><input type="checkbox" class="bulkBox" name="bulkBox" value="{{ $post->id }}" /></td>  
<td>{{ $post->focuskw }}</td>
<td>{{ $post->title }}</td>
@php
        $notes = json_decode($post->notes);
@endphp
<td>{{ $notes->length }}</td>
<td><form  action="{{ url('admin/keywords/GetPost') }}" style="display: inline;" method="post"> @csrf @method('post') <input type="hidden" name="postID" value="{{ $post->id }}" />
    <button {{ $newKeywords }} type="submit" class="btn btn-danger">بدء الكتابة</button></form></td>
</tr>
@endforeach
</tbody>
</table>
{{ $posts->appends(request()->query())->links() }}
</div>
</div>


@endsection
@section('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
 <script>
$('select').select2({placeholder:'الأقسام'});
</script>
<script>
       $('#bulkFormBTN').click(function(){

if( $('table.bulkedTable').find('input.bulkBox:checked').length == 0 || $('select[name="bulkType"]').val() == 0 || 
( $('select#categories4Bulk').val() == 0 && $('select[name="bulkType"]').val() == 'move' )  ||
( $('select#theStatus').val() == 0 && $('select[name="bulkType"]').val() == 'status' ) 
){
    alert('There is something wrong....');
    return false;
}

var bulkForm = $('form#bulkActionForm');
    var bulkKeywords = '';
    $('table.bulkedTable').find('input.bulkBox:checked').each(function(){
        bulkKeywords += $(this).val() + ",";
    });
    bulkForm.find('input.bulkKeywords').val(bulkKeywords);
    if( confirm('sure to continue?') ){
        bulkForm.submit();
    }else{
        return false;
    }

});

    $('input.checkAll').click(function(){
            $('table.bulkedTable').find('input.bulkBox').prop('checked', $(this).prop('checked') );
    });
</script>
@endsection