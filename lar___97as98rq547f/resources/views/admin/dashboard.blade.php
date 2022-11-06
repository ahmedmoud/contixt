@extends('admin.master')
@section('title', 'Admin Dashboard')
@section('content')

<img src="{{ url('uploads/assets/images/logo.png') }}" style=" display: block; margin: 40px auto; " />

@if( \UPerm::ClearCache() )

<button type="button" class="btn btn-danger cacheBTN" onclick="clearMyCache();">Clear Cache</button>
<button type="button" class="btn btn-danger cacheBTN" onclick="clearGoldCache();">Clear Gold Cache</button>

<div id="status">
    <img src="{{ url('uploads/assets/loading.gif') }}" style=" max-width: 100px; margin: auto; display:none;" /><b></b>
</div>

<style> .ShowMe{ display: block !important; } .HideMe{ display:none !important; } #status b{ text-align: center; width: 100%; display: block; margin: 12px 0; font-size: 21px; font-family: sans-serif; } button.cacheBTN{ margin: auto; text-align: center; width: 100%; display: block; max-width: 200px; margin-top: 9px; font-family: sans-serif; font-size: 17px; } </style>
<script>

function clearMyCache(){

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });


$('#status img').toggleClass('ShowMe');
$('#status b').toggleClass('HideMe');

$.ajax({
    url: "{{ url('/admin/clear-cache') }}",
    type: 'post',
}).done(function(data){
    $('#status img').toggleClass('ShowMe');
    $('#status b').toggleClass('HideMe');
    $('#status b').html(data);
    
});
}
function clearGoldCache(){

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });


$('#status img').toggleClass('ShowMe');
$('#status b').toggleClass('HideMe');

$.ajax({
    url: "{{ url('/admin/clear-gold-cache') }}",
    type: 'post',
}).done(function(data){
    $('#status img').toggleClass('ShowMe');
    $('#status b').toggleClass('HideMe');
    $('#status b').html(data);
    
});
}
</script>
@endif

@endsection