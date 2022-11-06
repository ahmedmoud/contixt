@extends('admin.master')
@section('title', 'Add Categories')
@php
    $isEdit = isset($permission) && $permission->id;
@endphp
@section('content')
<?PHP

if( $role->id == 8 ){
    echo '<h3>Blocked users can not have any permission!</h3>';
    die;
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if($isEdit)
                        تعديل صلاحية
                    @else
                        إنشاء صلاحية
                    @endif
                </h4>
                @if($isEdit)
                    <form class="form" action="{{ url('/admin/permissions/'. $role->id) }}" method="post">
                        @method('PUT')
                @else
                    <form class="form" action="{{ url('/admin/permissions/' . ($role->id ?? '')) }}" method="post">
                @endif
                    @csrf
                        @if($role)
                            <div class="form-group">
                                <label for="">الرتبة:{{ $role->name }}</label>
                                <input type="hidden" name="role_id" value="{{ $role->id }}" />
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                @foreach( $perms as $perm ) 
                                    <h4>
                                        <input type="hidden" name="perm__{{$perm->id}}" value="0" />

                                        <input type="checkbox" name="perm__{{$perm->id}}" @if(   in_array($perm->id, $rperms) ) checked @endif value="1" />
                                        {{ $perm->section }} : {{ $perm->description }} </h4>
                                @endforeach    
                                </div>    
                            </div>        
                        </div>
                        
                        
                    <button type="submit" class="btn btn-success btn-block">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

