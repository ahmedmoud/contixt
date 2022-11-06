@extends('admin.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('nativeAds.store') }}" method="POST">

                        @csrf
<div class="form-group">
    <label for="title">العنوان </label>
    <input name="title" type="text" class="form-control" id="title" >
</div>


<div class="form-group">
    <label for="pid">Post ID - only one post ID </label>
    <input name="pid" type="text" style="direction:ltr;text-align:left;" class="form-control" id="ord"  min="1">
</div>

<div class="form-group">
              <label for="title">الحالة</label>
              <div class="input-group mb-3">
    <lable for="fstatus"> <input id="fstatus" required="" type="radio" name="status" value="1"> نشط</lable>
         <lable for="sstatus"> <input id="sstatus" required="" type="radio" name="status" value="2"> غير نشط </lable>

                 
              </div>
          </div>

<script>
var widgets = {!! json_encode($widgets) !!};
</script>

<div id="placements"></div>
<button class="btn btn-danger" type="button" onclick="NewPlacement();">Add New Placemnet</button>

                        <button class="btn btn-success" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
        select{
            width: 90% !important;
            margin-left: 2%;
        }
        </style>
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
</script>
@endsection