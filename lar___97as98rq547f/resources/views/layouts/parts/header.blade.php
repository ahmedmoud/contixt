@php $slocale = App::isLocale('en') ? 'en_' : ''; @endphp
<div class="header-bottom d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-none d-lg-block">
                <div class="nav-action-elements-layout2">
                    <ul class="nav-social">
                        <li><a href="#" title="facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" title="twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="#" title="pinterest"><i class="fab fa-pinterest-p"></i></a></li>
                        <li><a href="#" title="skype"><i class="fab fa-skype"></i></a></li>
                        <li><a href="#" title="rss"><i class="fas fa-rss"></i></a></li>
                        <li><a href="#" title="google-plus"><i class="fab fa-google-plus-g"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <div class="site-logo-desktop">
                    <a href="{{ url('/') }}" class="main-logo"><img src="{{ url('uploads/des/img/foodo.png') }}" alt="Foodo"></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="nav-action-elements-layout3">
                    <ul>
                        <li>
                            <div class="header-search-box">
                                <a href="#search" title="Search" class="search-button">
                                    <i class="flaticon-search"></i>
                                </a> 
                            </div>
                        </li>
                       
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</header>