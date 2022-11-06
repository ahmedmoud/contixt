<style>.asdfasd a{ max-width: 182px; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: nowrap; display: inline-block; border: 0; } .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; }
</style>

    <div class="table-responsive m-t-40">
    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>العنوان</th>
        <th>Post ID</th>
        <th>الحالة</th>
        <th>Action</th>
    </tr>
    </thead>
    
    @foreach( $ads as $ad )
    <tr >
    <td>{{ $ad->id }}</td>
    <td>{{ $ad->title }}</td>
    <td>{{ $ad->pid }}</td>
    
    @if( $ad->status == 1)
    <td class='ActiveP'>
    نشط
    @else
    <td class='DraftP'>
    غير نشط
    @endif
    </td>
    <td>
        <a href="{{ route('nativeAds.edit', $ad->id) }}" class="btn btn-info">
        تعديل
        </a>
        
        <form onclick="return confirm('هل متأكد من الحذف؟');" action="{{ route('nativeAds.destroy',$ad->id) }}" style="display: inline;" method="post"> @csrf @method('DELETE')<button type="submit" class="btn btn-danger">حذف</button></form>

    </td>
    </tr>
    @endforeach

    </tbody>
    </table>
    {{ $ads->appends(request()->query())->links() }}
    </div>
    </div>