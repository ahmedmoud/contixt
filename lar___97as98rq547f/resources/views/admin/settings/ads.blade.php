@extends('admin.master')

@section('content')

    <div class="container-fluid">
		<div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(isset($changes))
                            <div class="alert alert-success">
                                <ul class="text-center list-unstyled">
                                    @foreach (session()->get('changes') as $msg)
                                        <li>{{ $msg }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ url('/admin/ads') }}" method="POST">
                        
                            @csrf
                            
                            <div class="form-group">
                                <label for="_HeaderAd">إعلان الهيدر</label>
                                <textarea name="_HeaderAd" id="_HeaderAd" cols="30" rows="5" class="form-control" style="direction: ltr;">{{ Setting::get('_HeaderAd') }}</textarea>
                            </div>



                            <div class="form-group">
                                <label for="_FooterAd">إعلان الفوتر </label>
                                <textarea name="_FooterAd" id="_FooterAd" cols="30" rows="5" class="form-control" style="direction: ltr;">{{ Setting::get('_FooterAd') }}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="_UnderMatbakhSetaat">إعلان تحت مطبخ ستات </label>
                                <textarea name="_UnderMatbakhSetaat" id="_UnderMatbakhSetaat" cols="30" rows="5" class="form-control" style="direction: ltr;">{{ Setting::get('_UnderMatbakhSetaat') }}</textarea>
                            </div>
                            
                            <div class="form-group">
<label for="BlockAdsenseAdsPosts">منع الإعلانات في المقالات التالية باستخدام Post ID ( الفاصل , انجلش )</label>
<textarea name="BlockAdsenseAdsPosts" id="BlockAdsenseAdsPosts" cols="30" rows="5" class="form-control" style="direction: ltr;">{{ Setting::get('BlockAdsenseAdsPosts') }}</textarea>
                            </div>

                            <div class="form-group">
<label for="BlockAdsenseAdsPostsKewords">منع الإعلانات في المقالات التالية باستخدام title Keywords ( الفاصل , انجلش )</label>
<textarea name="BlockAdsenseAdsPostsKewords" id="BlockAdsenseAdsPostsKewords" cols="30" rows="5" class="form-control" style="direction: ltr;">{{ Setting::get('BlockAdsenseAdsPostsKewords') }}</textarea>
                            </div>

                            
                            <button class="btn btn-success" type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
