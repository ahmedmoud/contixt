<style>.asdfasd a{ max-width: 182px; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: nowrap; display: inline-block; border: 0; } .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; }
.rejectedP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; }
</style>
                        
    <div class="table-responsive m-t-40">
    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
    <thead>
    <tr>
    <th>ID</th>
    <th>المستخدم</th>
    <th>الحالة</th>
    <th>البيانات</th>
    </tr>
    </thead>


    <tbody>
    @foreach($posts as $post)
    <tr >
    <td>{{ $post->id }}</td>
    <td><a href="{{ url('/admin/search-posts?user='.$post->author->id) }}">{{ $post->author->name }}</a></td>
    @if( intval($post->status) == 1 && $post->author->role_id != null )
    <td class='ActiveP'>
    منضم
    @elseif( intval($post->status) == 0 )
    <td class='DraftP'>
     لم تتم مراجعته
    @else
    <td class='rejectedP'>
    مرفوض
    @endif
    </td> 
    <td>
    <a href="{{ url('admin/joinUs/'.$post->id.'/view') }}" class="btn btn-info" > مشاهدة</a>
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    {{ $posts->appends(request()->query())->links() }}
    </div>
    </div>