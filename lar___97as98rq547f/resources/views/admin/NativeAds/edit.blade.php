@extends('admin.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('nativeAds.update', $ad->id) }}" method="POST">
@method('PUT')
                        @csrf
<div class="form-group">
    <label for="title">العنوان </label>
    <input name="title" type="text" class="form-control" id="title" value="{{ $ad->title }}">
</div>

<div class="form-group">
    <label for="pid">Post ID</label>
    <input name="pid" type="text" style="direction:ltr;text-align:left;" class="form-control" id="ord"  min="1"  value={{ $ad->pid }}>
</div>

<div class="form-group">
              <label for="title">الحالة</label>
              <div class="input-group mb-3">
    <lable for="fstatus"> <input id="fstatus" @if( $ad->status == 1 ) checked @endif required="" type="radio" name="status" value="1"> نشط</lable>
    <lable for="sstatus"> <input id="sstatus" @if( $ad->status == 0 ) checked @endif required="" type="radio" name="status" value="0"> غير نشط </lable>

                 
              </div>
          </div>


<style>
select{
    width: 90% !important;
    margin-left: 2%;
}
</style>
<div id="placements">

    @foreach( $places as $key=>$place )
    <div class="row placeX"><div class="form-group"><div class="col-md-4"><input class="form-control" style="width:100%" type="text" name="places[{{ $key }}][ord]" value="{{ $place->ord }}" placeholder="الترتيب" /></div></div><div class="col-md-8"><div class="form-group"><select name="places[{{ $key }}][widget_id]" class="form-control">@foreach( $widgets as $wd )<option @if( $wd->id == $place->widget_id ) selected @endif value="{{ $wd->id }}">{{ $wd->name. ' - ' .$wd->title }}</option>@endforeach </select><button type="button" class="btn btn-danger" onclick="removeMe(this);" >X</button></div> </div></div>
    @endforeach

</div>
<button class="btn btn-danger" type="button" onclick="NewPlacement();">Add New Placemnet</button>

<button class="btn btn-success" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script> 

function NewPlacement(){
    var length = $('.placeX').length;
    var place = '<div class="row placeX"><div class="form-group"><div class="col-md-4"><input class="form-control" style="width:100%" type="text" name="places['+length+'][ord]" placeholder="الترتيب" /></div></div><div class="col-md-8"><div class="form-group"><select name="places['+length+'][widget_id]" class="form-control">@foreach( $widgets as $wd )<option value="{{ $wd->id }}">{{ trim($wd->name) }} - {{ trim($wd->title) }}</option>@endforeach </select><button type="button" class="btn btn-danger" onclick="removeMe(this);" >X</button></div></div></div>';
    $('#placements').append(place);
}

function removeMe(btn){
    $(btn).parent().parent().parent().remove();
}

</script>
@endsection