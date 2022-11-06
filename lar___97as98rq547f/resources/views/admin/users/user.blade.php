<tr>
    <td>{{ title_case($user->name) }}</td>
    <td>{{ $user->username }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role->name ?? '' }}</td>
    <td>@if( $user->provider == 'facebook' ) <i class="fa fa-facebook"></i> @elseif( $user->provider == 'twitter' ) <i class='fa fa-twitter'></i> @else {{ $user->provider }} @endif </td>
    <td>
    <a href="{{ $user->url->edit }}" class="btn btn-info">{{ __('admin.edit') }} </a>
    <a onclick="return {{  'confirm(\''.__('admin.sure_to_remove_user').'\');' }} " href="{{ url('/admin/users/'.$user->id.'/remove') }}" class="btn btn-danger">{{ __('admin.remove') }}</a>
    </td>
</tr>