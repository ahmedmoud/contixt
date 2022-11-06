@extends('admin.master')
@section('title', 'Admin Categories')
@section('styles')

@endsection
@section('content')


<div>
    <a href="{{ url('admin/recipes_types/'.$type.'/create') }}" class="btn btn-primary" style="margin: 10px;">إضافة {{ $title }}</a>
    <br>
</div>
<div class="row">
    <div class="col-12"> 
        <div class="card">
            <div class="card-body">
                
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('admin.title') }}</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $cat)
                            <tr>
                                <td>{{ $cat->name }}</td>
                                @if( !in_array($cat->id, [9,10,11]) )
                                <td>
                                    <a href="{{ url('admin/recipes_types/'.$type.'/'.$cat->id.'/edit') }}" class="btn btn-info">
                                    {{ __('admin.edit') }}
                                    </a>
                               
                                    <form onclick="return confirm('هل متأكد من حذف هذا القسم؟');" action="{{ url('admin/recipes_types/'.$type.'/'.$cat->id) }}" style="display: inline;" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button type="submit" class="btn btn-danger"> {{ __('admin.remove') }}</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $data->render() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection