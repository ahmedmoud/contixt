@extends('admin.master')
@section('title', 'Admin Slider')
@section('content')

@include('media::modal')
{{-- Display Error --}}
@stack('media-styles')
@stack('media-scripts')

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="margin:10px;">
    Add Images
 </button>


<div class="collapse" id="collapseExample">
@if ($errors->any())
      <div class="alert alert-danger">
          <ul class="list-unstyled">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <div class="card">
      <div class="card-body">
	      <h4 class="card-title">اضافة صور</h4>
	      <form class="form-horizontal m-t-40" method="post" action="{{url('admin/slider/store')}}" enctype="multipart/form-data" >
	        @csrf
                {{-- <input required type="file" class="form-control" name="images[]" multiple> --}}
                @include('media::btn',['Mid'=>'image','Mtitle'=>'صور الاسلايدر','Mtype'=>2])

                <button type="submit" class="btn btn-primary">Save</button>
           </form>
      </div>
  </div>
</div>

<div class="container">

  <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
                                <tdead>
                                    <tr>
                                        <th>الصورة</th>
                                        <th>الحالة</th>
                                        <th>actions</th>
                                    </tr>
                                </tdead>
                                
                                <tbody>
                                  @if(count($sliders))
                                  @foreach($sliders as $slider)
                                  <tr>
                                        <td><img src="{{ asset($slider->image) }}"  width="300px" height="200" class="rounded mx-auto d-block"></td>

                                          @if($slider->status) 
                                          <td>نشطة</td>
                                          @else
                                          <td>متوقفة</td>
                                          @endif
                                          <td>
                                          <form action="{{ url('admin/slider/'.$slider->id.'/change') }}" style="display: inline;" method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="PUT" />
                                                <input type="hidden" name="status" value="{{ $slider->status == 1 ? 0 : 1 }}">
                                                <button type="submit" class="btn @if($slider->status) btn-warning @else btn-success @endif">
                                                {{ ($slider->status == 1) ? 'تعطيل' : 'تفعيل' }}
                                                </button>
                                          </form>
                                          <form action="{{ url('admin/slider/'.$slider->id) }}" style="display: inline;" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit" class="btn btn-danger">
                                            حذف
                                            </button>
                                          </form>
                                        </td>
                                  </tr>
                                  @endforeach
                                  @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
    </div>    
</div>

@endsection