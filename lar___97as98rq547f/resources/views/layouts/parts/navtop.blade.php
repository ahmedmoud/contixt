<header class="header-one">
    <div id="header-main-menu" class="header-main-menu header-sticky">
        <div class="container">                    
            <div class="row">
                <div class="col-lg-12 col-md-3 col-sm-4 col-4 possition-static">
                    <div class="site-logo-mobile">
                        <a href="index.html" class="sticky-logo-light"><img src="{{ url('uploads/des/img/foodo.png') }}" alt="Foodo"></a>
                        <a href="index.html" class="sticky-logo-dark"><img src="{{ url('uploads/des/img/foodo.png') }}" alt="Foodo"></a>
                    </div>
                   
                    <nav class="site-nav">
                            {!! $menupreview !!}
                    </nav>
                </div>
                <div class="col-lg-4 col-md-9 col-sm-8 col-8 d-flex align-items-center justify-content-end">
                    
                    <div class="mob-menu-open toggle-menu">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>