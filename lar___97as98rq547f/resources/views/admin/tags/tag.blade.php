<tr>
    <td>{{ $tag->name }}</td>
    <td><a href="{{ url('/tags/'. $tag->slug) }}">{{ $tag->slug }}</a></td>
    <td>
        @if($tag->allowAddLang)
            <form action="{{ url('admin/tags/create') }}" style="display:inline" method="post">
                @csrf
                <input type="hidden" name="block" value="{{ $tag->block_id }}">
                <button class="btn btn-info" type="submit">@trans('add-language', 'Add Language')</button>
            </form>
        @endif

        <form action="{{ url('admin/tags/'.$tag->id) }}" style="display: inline;" method="post">
            @csrf
            <input type="hidden" name="_method" value="PUT" />
            <input type="hidden" name="status" value="@if($tag->isActive) 0 @else 1 @endif" />
            <button type="submit" class="btn @if($tag->isActive) btn-warning @else btn-success  @endif">
                @if($tag->isActive)
                    تعطيل
                @else
                    تفعيل
                @endif
            </button>
        </form>
        <a href="{{ url('admin/tags/'.$tag->id.'/edit') }}" class="btn btn-info">
            تعديل
        </a>

        <form action="{{ url('admin/tags/'.$tag->id) }}" style="display: inline;" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE" />
            <button type="submit" class="btn btn-danger">
                حذف
            </button>
        </form>
    </td>
</tr>