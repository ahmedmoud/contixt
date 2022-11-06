<style>.asdfasd a{ max-width: 182px; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: nowrap; display: inline-block; border: 0; } .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; }
</style>
                        
    <div class="table-responsive m-t-40">
    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
    <thead>
    <tr>
    <th>ID</th>
    <th>العنوان</th>
    <th>الناشر</th>
    <th>الحالة</th>
    <th>المشاهدات</th>
    <th>التعليقات</th>
    <th>Action</th>
    </tr>
    </thead>
    @php 
    $PostOwnerUpdate = UPerm::PostOwnerUpdate();
    $PostOtherUpdate = UPerm::PostOtherUpdate();

    $PostOwnerRemove = UPerm::PostOwnerRemove();
    $PostOtherRemove = UPerm::PostOtherRemove();
    $user__id = Auth::user()->id;
    @endphp
    <tbody>
    @foreach($posts as $post)
    <tr >
    <td>{{ $post->id }}</td>
    <td class="asdfasd"><a target="_blank" href="{{ url('/competition/'.$post->slug) }}">{{ $post->title }}</a></td>
    <td><a href="{{ url('/admin/search-posts?user='.$post->author->id) }}">{{ $post->author->name }}</a></td>
    @if( intval($post->status) == 1)
    <td class='ActiveP'>
    نشط
    @else
    <td class='DraftP'>
    غير منشور
    @endif
    </td>
    <td> {{ $post->views }} </td>
    <td> {{ $post->comments->count() }} </td>
    <td>
    @if( ($PostOwnerUpdate && $user__id == $post->user_id ) ||  ($PostOtherUpdate && $user__id != $post->user_id) )
        <a href="{{ url('admin/competitions/'.$post->id.'/edit') }}" class="btn btn-info">
        تعديل
        </a>
    @endif
    @if( ($PostOwnerRemove && $user__id == $post->user_id ) ||  ($PostOtherRemove && $user__id != $post->user_id) )
        {!! $post->deletionForm('حذف') !!}
    @endif
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    {{ $posts->appends(request()->query())->links() }}
    </div>
    </div>