<tr>
    <td>{{ $role->name }}</td>
    @if( $role->id != 8 )
    <td>
        <form action="{{ url('admin/roles/'.$role->id) }}" style="display: inline;" method="post">
            @csrf
            <input type="hidden" name="_method" value="PUT" />
            <input type="hidden" name="status" value="@if($role->isActive) 0 @else 1 @endif" />
            <button type="submit" class="btn @if($role->isActive) btn-warning @else btn-success  @endif">
                @if($role->isActive)
                    تعطيل
                @else
                    تفعيل
                @endif
            </button>
        </form>
        <a href="{{ url('admin/roles/'.$role->id.'/edit') }}" class="btn btn-info">
            تعديل
        </a>
                <a href="{{ url('admin/permissions/'.$role->id.'/create') }}" class="btn btn-primary">
            الصلاحيات
        </a>

        <form onsubmit="return confirm('هل متأكد من الحذف؟');" action="{{ url('admin/roles/'.$role->id) }}" style="display: inline;" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE" />
            <button type="submit" class="btn btn-danger">
                حذف
            </button>
        </form>
    </td>
    @endif
</tr>