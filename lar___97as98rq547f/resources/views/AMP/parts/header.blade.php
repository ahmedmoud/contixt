<div class="container">
    <div class="lefty">
    <a href="{{ url('/') }}" ><amp-img class="logo" src="{{ getLogo('header') }}" alt="{{ Setting::get('title') }}" height="104" width="256" layout="responsive" ></amp-img></a>
    </div>
    <button role="button" on="tap:sidebar1.toggle" tabindex="0" class="hamburger" >☰</button>
</div>
<amp-sidebar id="sidebar1" layout="nodisplay" side="right" class="ampMenu">
            <span role="button" aria-label="close sidebar" on="tap:sidebar1.toggle" tabindex="0" class="close-sidebar">✕</span>
{!! $menupreview !!}
</amp-sidebar>