<style>.feedback { background: grey; color: #fff; padding: 7px; font-weight: bold; border-radius: 4px; margin: 5px 0; }  input.bulkBox, input.checkAll { width: 20px; height: 20px; } .asdfasd a{ width: 100%; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: pre-wrap; display: inline-block; border: 0; min-width: 151px;} .ActiveP { background: #00c292; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .PendingP { background: #fb9678; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .DraftP { background: #03a9f3; text-align: center; color: #fff; line-height: 29px; font-weight: bold; } .fullWidth{ width: 100%; } select, input[type="text"] { width:100%; border-radius:5px; border:2px solid #4f5467; height:40px; padding:0 10px; } .rota { transform: rotate(-90deg); float: left; border-right: 0; border-left: 0; position: relative; display: inline; text-align: center; width: 11px; top: -26px; font-weight: bold; height: 44px; left: 11px; } span.good { display: block; width: 20px; height: 20px; background: #00c206; border-radius: 50%; text-align: center; margin: auto; } span.bad { display: inline-block; width: 20px; height: 20px; background: #f70303; border-radius: 50%; text-align: center; margin: auto; bottom:-4px; position:relative; }
td.asdfasd.a52s5 a { min-width: 116px; } td.asdfasd.a52s5 a { min-width: 116px; } .are547r7 { max-width: 135px; } .are547r7 a { display: block; text-overflow: ellipsis; /* white-space: pre-wrap; */ } td.publisher47 a { width: 100%; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: pre-wrap; display: inline-block; border: 0; min-width: 48px; }
.b4publish { background: #545454; }
</style>
<?PHP
$theUserID = Auth::user()->id;
if( isset($postsLengthes) && count($postsLengthes) > 0 ){
    $theLength = true;
}else{
    $theLength = false;
}

$PostsBulkAction = \UPerm::PostsBulkAction();
?>

    <div class="table-responsive m-t-40">
            @if( $errors->first('msg') )
                <div class="feedback">{{ $errors->first('msg') }}</div>
            @endif
    @if( $PostsBulkAction )
    <form  action="{{ url('/admin/posts/bulkActioin') }}" method="POST" id="bulkForm" style=" padding: 17px 10px; background: #eaeef2; margin: 7px; text-align: center; ">
        <h3>Bulk Action</h3>
        @csrf
<select name="bulkType" class="col-md-3 not-select2">
    <option value="0">Action</option>
    @if( \UPerm::BeKeyword() ) <option value="bekeyword">be a keyword</option>@endif
    @if( \UPerm::PostsBulkAction_move() ) <option value="move">Move</option>@endif
    @if( \UPerm::PostsBulkAction_status() ) <option value="status">Change Status</option> @endif
    @if( \UPerm::PostsBulkAction_delete() )<option value="delete">Delete</option>@endif
</select>
@if( \UPerm::PostsBulkAction_move() )
<select id="categories4Bulk" style="display:none;" name="categories4Bulk" class="col-md-3 not-select2">
    <option value="0">القسم</option>
   @foreach( \App\Category::where('lang', \App::getLocale() )->orderBy('id','desc')->select('name','id')->get() as $singleCate )
   <option value="{{ $singleCate->id }}">{{ $singleCate->name }}</option>
   @endforeach
</select>
@endif
@if( \UPerm::PostsBulkAction_status() )
<select name="theStatus" id="theStatus" style="display:none;" class="col-md-3 not-select2">
    <option value="0">الحالة</option>
    <option value="1">منشور</option>
    <option value="2">المراجعة </option>
    <option value="3">مسودة</option>
    <option value="4">جاهز للنشر</option>
</select>
@endif
        <input type="hidden" class="BulkPostsIDs" name="BulkPostsIDs" />
        <button type="button" id="bulkFormBTN" class="btn btn-primary">Submit</button>
    </form>
    <br/>
    @endif
    
    <table id="example23" class="bulkedTable display nowrap table table-hover table-striped table-bordered" cellspacing="0" widtd="100%">
    <thead>
    <tr>
        @if( $PostsBulkAction )<th> <input type="checkbox" class="checkAll" /> </th>@endif
        <th>ID</th>
        <th>{{ __('admin.title') }}</th>
        @if( $theLength ) <th> عدد الكلمات </th> @endif
        <th>Keyword</th>
        <th>{{ __('admin.categories') }}</th>
        <th>{{ __('admin.publisher') }}</th>
        <th>OnPage</th>
        <th><span class="rota">الكتابة</span></th>
        <th><span class="rota">النشر</span></th>
        <th><span class="rota">التحديث</span></th>
        <th><span class="rota">{{ __('admin.status') }}</span></th>
        <th ><span class="rota">{{ __('admin.views') }}</span></th>
        <th ><span class="rota">{{ __('admin.comments') }}</span></th>
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
    <tr>
    @if( $PostsBulkAction ) <td><input class="bulkBox" type="checkbox" value="{{ $post->id }}" /></td> @endif
    <td>{{ $post->id }}</td>
    <td class="asdfasd"><a target="_blank" href="{{ asset($post->slug) }}">{{ $post->title }}</a></td>
    @if( $theLength && isset($postsLengthes[$post->id]) )<td class="asdfasd wordCounter">{{  $postsLengthes[$post->id]    }}</td> @endif
    <td class="asdfasd a52s5"><a>{{ urldecode($post->focuskw) }}</a></td>
    <td class="text-center"><div class="are547r7">{!!  $post->categoriesHTML() !!}</div></td>
    <td class="publisher47"><a href="{{ url('/admin/search-posts?user='.$post->author->id) }}">{{ $post->author->name }}</a></td>
    <td class="status47">{{ $post->seoStatus ? $post->seoStatus : '' }} <span class="{{ $post->seoStatus ? 'bad' : 'good' }}"></span></td>
    <td><a class="rota" href="{{ url('/admin/search-posts?date='.\Carbon\Carbon::parse($post->dob)->format('Y-m-d') ) }}">{{ Carbon\Carbon::parse($post->dob)->format('Y-m-d') }}</a></td>
    <td><a class="rota" href="{{ url('/admin/search-posts?date='.\Carbon\Carbon::parse($post->created_at)->format('Y-m-d') ) }}">{{ Carbon\Carbon::parse($post->created_at)->format('Y-m-d') }}</a></td>
    <td><a class="rota" href="{{ url('/admin/search-posts?date='.\Carbon\Carbon::parse($post->updated_at)->format('Y-m-d') ) }}">{{ Carbon\Carbon::parse($post->updated_at)->format('Y-m-d') }}</a></td>
    @if( intval($post->status) == 1)
    <td class='ActiveP'>
    <span class="rota">
    {{ __('admin.publish') }}
    @elseif( intval($post->status) == 2 )
    <td class='PendingP'>
    <span class="rota">
    {{ __('admin.revision') }}
    @elseif( intval($post->status) == 4 )
    <td class='PendingP b4publish'>
    <span class="rota">
    {{ __('admin.ready4Publish') }}
    @else
    <td class='DraftP'>
    <span class="rota">
    {{ __('admin.draft') }}
    @endif
    </span>
    </td>
    <td> {{ $post->views }} </td>
    <td> {{ $post->comments->count() }} </td>
    <td>
    @if( ($PostOwnerUpdate && $user__id == $post->user_id ) ||  ($PostOtherUpdate && $user__id != $post->user_id) ) 
        <a href="{{ $post->type == 'resala' ? url('/admin/resala/'.$post->id.'/edit') : $post->url->edit }}" class="btn btn-info">
        {{ __('admin.edit') }}
        </a>
    @endif
    @if( ($PostOwnerRemove && $user__id == $post->user_id ) ||  ($PostOtherRemove && $user__id != $post->user_id) )
        {!! $post->deletionForm( __('admin.remove') ) !!}
    @endif
    @if( $post->editsID )
        <a class="btn btn-info" href="{{ url('admin/post-all-edits/'.$post->id) }}">التعديلات السابقة</a>
    @endif
    @if( UPerm::ControlPostsFUpdates() || ( UPerm::ControlHisPostsFUpdates() && ( $theUserID == $post->user_id || ( $theUserID == 869 && $post->user_id == 999 ) ) ) )
    <a class="btn btn-warning" href="{{ url('admin/future-updates/'.$post->id) }}">
        التحديثات
        ({{ $post->NUpdates() }})</a>
    @endif
    </td>
    </tr>
    @endforeach

    </tbody>
    </table>
    {{ $posts->appends(request()->query())->links() }}
    </div>
    </div>

@section('scriptss')
<script>

$('select[name="bulkType"]').change(function(){
        if( $(this).val() == 'move' ){
            $('select#categories4Bulk').show();
            $('select#theStatus').hide();

        }else if( $(this).val() == 'status' ){
            $('select#theStatus').show();
            $('select#categories4Bulk').hide();

        }else{
            $('select#theStatus').hide();
            $('select#categories4Bulk').hide();
        }
    });

   $('#bulkFormBTN').click(function(){

    if( $('table.bulkedTable').find('input.bulkBox:checked').length == 0 || $('select[name="bulkType"]').val() == 0 || 
    ( $('select#categories4Bulk').val() == 0 && $('select[name="bulkType"]').val() == 'move' )  ||
    ( $('select#theStatus').val() == 0 && $('select[name="bulkType"]').val() == 'status' ) 
    ){
        alert('There is something wrong....');
        return false;
    }

    var bulkForm = $('form#bulkForm');
        var bulkedPosts = '';
        $('table.bulkedTable').find('input.bulkBox:checked').each(function(){
            bulkedPosts += $(this).val() + ",";
        });
        bulkForm.find('input.BulkPostsIDs').val(bulkedPosts);
        if( confirm('sure to continue?') ){
            bulkForm.submit();
        }else{
            return false;
        }

    });

    $('input.checkAll').click(function(){
            $('table.bulkedTable').find('input.bulkBox').prop('checked', $(this).prop('checked') );
    });

</script>
    
@endsection