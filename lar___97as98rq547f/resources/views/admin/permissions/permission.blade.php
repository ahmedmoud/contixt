<tr>
    <td>{{ $permission->action }}</td>
    <td>{{ title_case(str_replace('-', ' ', $permission->section)) }}</td>
    <td>{{ $permission->description }}</td>
    <!--<td>-->
    <!--    <form action="{{ url('admin/permissions/'.$role->id. '/'.$permission->id) }}" style="display: inline;" method="post">-->
    <!--        @csrf-->
    <!--        <input type="hidden" name="_method" value="DELETE" />-->
    <!--        <button type="submit" class="btn btn-danger">-->
    <!--            حذف-->
    <!--        </button>-->
    <!--    </form>-->
    <!--</td>-->
</tr>