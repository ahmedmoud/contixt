@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
 
		<div>
            @can('create', 'posts')
			    <a href="{{ url('admin/posts/create') }}" class="btn btn-primary" style="margin: 10px;">إضافة منشور جديد</a>
            @endcan
			<br>
		</div>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                        
<style>.asdfasd a{ max-width: 182px; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: nowrap; display: inline-block; border: 0; } .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; }
</style>
                        
    <div class="table-responsive m-t-40">
    
    <h2 class="text-center">{{ $order->author->name }}</h2>
    <div>
    @if( intval($order->status) == 1 && $order->author->role_id != null )
    <p class='ActiveP'>
    منضم
    @elseif( intval($order->status) == 0 )
    <p class='DraftP'>
     لم تتم مراجعته
    @else
    <p class='rejectedP'>
    مرفوض
    @endif
    </p>
    </div>

<div class="col-md-7">

@if( isset($order->data->files) )
    <h3>ملفات سابقة الأعمال</h3>
    @foreach( $order->data->files as $link )
        <a href="{{ url($link) }}">{{ url($link) }}</a><br/>
    @endforeach

@endif
<br/>
@if( isset($order->data->oldURLs) )

    <h3>روابط سابقة الأعمال</h3>
    @foreach( explode("\n", $order->data->oldURLs) as $link )
        <a href="{{ $link }}">{{ urldecode($link) }}</a><br/>
    @endforeach
@endif
</div> <br/>
<div class="col-md-5">
@if( isset($order->data->experience) )
خبرة بالكتابة: <b>@if( $order->data->experience ) نعم @else لا @endif</b>
@endif
<br/>
@if( isset($order->data->notice) && $order->data->notice )
        <h3>ملاحظات</h3>
        <p>{{ $order->data->notice }}</p>
@endif


<hr>
<form action="{{ url('admin/joinUs/accept') }}" method="post">
@csrf
<select name="role_id">
    @foreach( $roles as $role )
    <option value="{{ $role->id }}">{{ $role->name }}</option>
    @endforeach 
</select>
<input type="hidden" name="user_id" value="{{ $order->user_id }}" />
<input type="hidden" name="order_id" value="{{ $order->id }}" />
<input type="submit" class="btn btn-primary">قبول</a>
</form>
يتم قبول العضو عن طريق تغيير رتبة العضوية الخاصه به
<br/><br/>  
<hr>
<form action="{{ url('admin/joinUs/reject') }}" method="post">
@csrf
<input type="hidden" name="user_id" value="{{ $order->user_id }}" />
<textarea placeholder="سبب الرفض" name="reason" ></textarea>
<input type="hidden" name="id" value="{{ $order->id }}" />
<input type="submit" value="رفض" class="btn btn-primary"/>
</form>

</div>
    </div>
    </div>

                    </div>
                </div>
               
            </div>
		</div>		


@endsection