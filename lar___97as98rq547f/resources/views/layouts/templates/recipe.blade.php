<div class="item-feature">
                <ul>
                    <li>
                        <div class="feature-wrap">
                            <div class="media">
                                <div class="feature-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="feature-title">وقت الطبخ</div>
                                    <div class="feature-sub-title">{{  $recipe->cookTimeM  }}  دقيقة</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="feature-wrap">
                            <div class="media">
                                <div class="feature-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="feature-title">وقت التجهيز</div>
                                    <div class="feature-sub-title">{{  $recipe->prepTimeM  }} دقيقة</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="feature-wrap">
                            <div class="media">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="feature-title">تكفي لـ</div>
                                    <div class="feature-sub-title">{{  $recipe->yield  }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="feature-wrap">
                            <div class="media">
                                <div class="feature-icon">
                                    <i class="far fa-eye"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="feature-title">المشاهدات</div>
                                    <div class="feature-sub-title">{{ $post->views }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
</div>
            <p class="item-description">{!! $post->excerpt !!}</p>
                    <div class="making-elements-wrap">
                        <div class="row">
                            <div class="col-xl-6 col-12">
                                <div class="ingridients-wrap">
                                    <h3 class="item-title"><i class="fas fa-list-ul"></i>المقادير</h3>



<ul>
        @foreach( $theRecipe->ingredients as $k=>$ing ) 
        @if( strpos($ing,'#') === 0 )
</ul>
<h3 class="adjust-servings servings-title">{{ str_replace('#','', $ing) }}</h3>
<ul> 
        @else
        <li class="checkbox checkbox-primary">
                        <input id="checkbox{{ $k }}" type="checkbox"><label for="checkbox{{ $k }}">{{ $ing }}</label>
                </li>
        @endif
        @endforeach
</ul> 

                                </div>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="nutrition-wrap">
                                    <h3 class="item-title"><i class="fas fa-info"></i>القيم الغذائية</h3>
                                    <ul class="nutrition-list">
                                        @if( strlen($recipe->calories) > 0 ) <li>
                                            <div class="nutrition-name">سعرات</div>
                                            <div class="nutrition-value">{{  $recipe->calories  }}</div>
                                        </li>@endif
                                        @if( strlen($recipe->fatContent) > 0 ) <li>
                                            <div class="nutrition-name">دهون</div>
                                            <div class="nutrition-value">{{  $recipe->fatContent  }} </div>
                                        </li>@endif
                                        @if( strlen($recipe->protein) > 0 ) <li>
                                            <div class="nutrition-name">بروتين</div>
                                            <div class="nutrition-value">{{  $recipe->protein  }}</div>
                                        </li>@endif
                                        @if( strlen($recipe->carbohydrates) > 0 ) <li>
                                            <div class="nutrition-name">كربوهيدرات</div>
                                            <div class="nutrition-value">{{  $recipe->carbohydrates  }}</div>
                                        </li>@endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

<div class="item-feature">
<ul>
        <li>
                <div class="feature-wrap">
                        <div class="media">
                        <div class="feature-icon">
                                <i class="far fa-money"></i>
                        </div>
                        <div class="media-body space-sm">
                                <div class="feature-title">التكلفة</div>
                                <div class="feature-sub-title">{{  $recipe->theCost  }} </div>
                        </div>
                        </div>
                </div>
                </li>
                <li>
                        <div class="feature-wrap">
                                <div class="media">
                                <div class="feature-icon">
                                        <i class="far fa-money"></i>
                                </div>
                                <div class="media-body space-sm">
                                        <div class="feature-title">طريقة الطهي</div>
                                        <div class="feature-sub-title">{{  $recipe->theCookMethod  }} </div>
                                </div>
                                </div>
                        </div>
                        </li>
                        <li>
                                <div class="feature-wrap">
                                        <div class="media">
                                        <div class="feature-icon">
                                                <i class="far fa-money"></i>
                                        </div>
                                        <div class="media-body space-sm">
                                                <div class="feature-title">من المطبخ</div>
                                                <div class="feature-sub-title">{{  $recipe->theCuisine  }} </div>
                                        </div>
                                        </div>
                                </div>
                                </li>
                                <li>
                                        <div class="feature-wrap">
                                                <div class="media">
                                                <div class="feature-icon">
                                                        <i class="far fa-money"></i>
                                                </div>
                                                <div class="media-body space-sm">
                                                        <div class="feature-title">نوع الوصفة</div>
                                                        <div class="feature-sub-title">{{  $recipe->theCategory  }} </div>
                                                </div>
                                                </div>
                                        </div>
                                        </li>
</ul>
</div>
                    
    <div class="direction-wrap-layout1">
    <div class="section-heading heading-dark">
        <h2 class="item-heading">طريقة تحضير {{ $recipe->recipeName  }} بالخطوات</h2>
    </div>
<ul class="ingredients">@foreach( $theRecipe->instructions as $kk=>$ing ) @php $kkk = 1 + $kk; @endphp
    @if( strpos($ing,'#') === 0 ) 
</ul>
<h3 class="unerlinePink">{{ str_replace('#','', $ing) }}</h3>
<ul>
    @else
    <li><div class="direction-box-layout1"><div class="item-content"><div class="serial-number">{{ $kkk }}</div><p>{{ $ing }}</p> </div></div></li>  
    @endif
    @endforeach
</ul>
    </div>
                    <br/>
<div class="lastBox">
        @if( $post->recipe->notice )
        <p>{{ $post->recipe->notice }}</P>
        @endif
        <p>كده قدمنالك طريقة عمل <strong>{{ $post->recipe->recipeName }}</strong> من <a href="{{ url('/') }}">فودو</a> . ماتنسيش تقوليلنا رأيك في الوصفة لما تجربيها</p>
</div>