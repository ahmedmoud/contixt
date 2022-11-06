@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
 
		<div>
            @can('create', 'posts')
			    <a href="{{ url('admin/posts/create') }}" class="btn btn-primary" style="margin: 10px;">إضافة منشور جديد</a>
            @endcan
			<br>
		</div>


<style>.asdfasd a{ width: 100%; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: pre-wrap; display: inline-block; border: 0; min-width: 203px;} .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; }
</style>

    @php 
    $PostOwnerUpdate = UPerm::PostOwnerUpdate();
    $PostOtherUpdate = UPerm::PostOtherUpdate();
    
    $PostOwnerRemove = UPerm::PostOwnerRemove();
    $PostOtherRemove = UPerm::PostOtherRemove();
    $user__id = Auth::user()->id;
    @endphp

    <div class="table-responsive m-t-40">
    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
    <thead>
    <tr>
    <th>Edit ID</th>
    <th>Post ID</th>
    <th>{{ __('admin.main') }}</th>
    <th>{{ __('admin.user') }}</th>
    <th>{{ __('admin.creation_date') }}</th>
    <th>{{ __('admin.edit_date') }}</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
    <tr >
    <td>{{ $post->id }}</td>
    <td>{{ $post->post_id }}</td>
    <td class="asdfasd"><a target="_blank" href="{{ asset($post->pslug) }}">{{ $post->ptitle }}</a></td>
    <td><a href="{{ url('/admin/search-posts?user='.$post->author->id) }}">{{ $post->author->name }}</a></td>
    <td><a >{{ $post->dob }}</a></td>
    <td><a >{{ $post->created_at }}</a></td>
    <td>
    <a href="{{ url('admin/post-edits/'.$post->id) }}" class="btn btn-info">
        {{ __('admin.view_edits') }}
    </a> 
    @if( ($PostOwnerUpdate && $user__id == $post->user_id ) ||  ($PostOtherUpdate && $user__id != $post->user_id) ) 
    <a href="{{ url('admin/posts/'.$post->post_id.'/edit') }}" class="btn btn-info">
    {{ __('admin.edit_original') }}
    </a> 
    @endif
    </td>
    </tr>
    @endforeach

    </tbody>
    </table>
    {{ $posts->appends(request()->query())->links() }}
    </div>
    </div>

@endsection