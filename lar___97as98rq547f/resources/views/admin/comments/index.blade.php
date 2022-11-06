@extends('admin.master')
@section('title', 'Admin Categories')
@section('content')
          <style>
.asdfasd a{ max-width: 182px; overflow: hidden; display: inline-b; text-overflow: ellipsis; white-space: nowrap; display: inline-block; border: 0; }
.ptagOver {
                               white-space: pre-wrap; max-height: 125px; overflow-y: scroll; }
                            }
                        </style>
<script>
function checkBeforeRemove() {
     return confirm("هل متأكد من حذف هذا التعليق؟!");
}
</script>
<style>
span.vistor {
    position: absolute;
    bottom: 0;
    left: 0;
    background: #d54150bf;
    padding: 7px;
    color: #fff;
    border-radius: 5px;
}
</style>
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive m-t-40">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <tdead>
                                    <tr>
                                        <th>اسم العضو والمستخدم</th>
                                        <th>المقال</th>
                                        <th>التعليق</th>
                                        <th>actions</th>
                                    </tr>
                                </tdead>
                                
                                <tbody>
@foreach($comments as $comment)
<tr>
<td style="position:relative;">
@if( $comment->user_id == 630 && !empty($comment->name) )
<span class="vistor">زائر</span>
<span>{{ $comment->name }}</span><br/>
<span>{{ $comment->email }}</span><br/><br/>
@else
<a >{{ $comment->user->name }} / {{ $comment->user->username }}</a>
@endif
</td>
<td class="asdfasd"><a target="_blank" href="@if( $comment->post->slug ){{ url($comment->post->slug) }}@endif">{{ $comment->post->title }}</a></td>
<td><p class="ptagOver">{{ $comment->comment }}</p></td>
<td>
@if( $comment->status == 0 )
<form action="" style="display: inline;" method="post"> @csrf <input type="hidden" name="how" value="1" /> <input type="hidden" name="commentID" value="{{ $comment->id }}" /> <button type="submit" class="btn btn-primary"> تفعيل </button> </form>
@else
<form action="" style="display: inline;" method="post"> @csrf <input type="hidden" name="how" value="0" /> <input type="hidden" name="commentID" value="{{ $comment->id }}" /> <button type="submit" class="btn btn-info"> تعطيل </button> </form>
@endif

<form action="" onsubmit="return checkBeforeRemove()" style="display: inline;" method="post"> @csrf @method('DELETE') <input type="hidden" name="commentID" value="{{ $comment->id }}" /> <button type="submit" class="btn btn-danger"> حذف </button> </form>
                                        </td>
                                       
                                	</tr>
                                	@endforeach

                                </tbody>
                            </table>
                        </div>
                        {!! $comments->render() !!}
                    </div>
                </div>
               
            </div>
		</div>		


@endsection