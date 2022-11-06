<div class="modal" id="gifModal" >
<div class="modal-body" style=" position: absolute; right: 0; left: 0; margin: auto; top: calc( 50% - 240px); bottom: 0; vertical-align: middle; padding: 0; ">
<a class="close" onclick="document.getElementById('gifModal').remove();" style="position: absolute;background: #fff !important;display: block;overflow: hidden;color: #ec106e;float: none;top: 0;right: 7%;font-size: 42px;z-index: 999;opacity: 1;border-radius: 50%;width: 40px;height: 40px;">×</a>
    <div id="gifModalContent"></div>
    @php /* $IMG */ @endphp
</div>
</div>
<script>
  
	function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) { 
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

    if( !( getCookie("pop_start") || getCookie("pop_mid") || getCookie("pop_end") )  ){
        
        var d = new Date();
        d.setDate(d.getDate() );
        var exp = "expires="+ d.toUTCString();
        document.cookie = "f1View=true;" + exp + ";path=/";
        document.cookie = "f2View=true;" + exp + ";path=/";
        
        var date = new Date();
        date.setDate(date.getDate() + 2);
        var expires = "expires="+ date.toUTCString();
        document.cookie = "pop_start=true;" + expires + ";path=/";
        
        date = new Date();
        date.setDate(date.getDate() + 4);
        expires = "expires="+ date.toUTCString();
        document.cookie = "pop_mid=true;" + expires + ";path=/";
        
        date = new Date();
        date.setDate(date.getDate() + 7);
        expires = "expires="+ date.toUTCString();
        document.cookie = "pop_end=true;" + expires + ";path=/";
        
    }
    
    if( !getCookie("pop_start") && getCookie("pop_mid") && getCookie("pop_end") && !getCookie("f1View") ){
        // First POP
        var date = new Date();
        date.setDate(date.getDate() + 2);
        var expires = "expires="+ date.toUTCString();
        document.cookie = "f1View=true;" + expires + ";path=/";
        document.getElementById("gifModal").className += " show ";
        var h = '<a target="_blank" href="https://www.youtube.com/channel/UCvC8_cOLcfpaOCKNUq458fg?sub_confirmation=1"><img src="{{ url('uploads/assets/images/youtube.gif') }}" /> </a>';
        document.getElementById("gifModalContent").innerHTML = h;
    }else if( !getCookie("pop_start") && !getCookie("pop_mid") && getCookie("pop_end") && !getCookie("f2View") ){
        // Second POP
        var date = new Date();
        date.setDate(date.getDate() + 2);
        var expires = "expires="+ date.toUTCString();
        document.cookie = "f2View=true;" + expires + ";path=/";
        document.getElementById("gifModal").className += " show ";
        var h = '<a href="{{ url('/register') }}" /><img src="{{ url('uploads/assets/images/subscribe.gif') }}" /> </a>';
        document.getElementById("gifModalContent").innerHTML = h;
    }
    
    
   
</script>