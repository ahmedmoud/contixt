@php $slocale = \App::isLocale('en') ? 'en_' : '' ; @endphp
<footer class="ranna-bg-dark">
     <div class="container">
         <div class="footer-logo">
             <a href="index.html"><img src="{{ url('uploads/des/img/foodo.png') }}" class="img-fluid" alt="foodo"></a>
         </div>
      
     </div>
 </footer>
 <!-- Footer Area End Here -->
</div>
<!-- Search Box Start Here -->
<div id="search" class="search-wrap">
 <button type="button" class="close">×</button>
 <form class="search-form">
     <input type="search" value="" placeholder="Type here........" />
     <button type="submit" class="search-btn"><i class="flaticon-search"></i></button>
 </form>
</div>
<!-- Search Box End Here -->
<!-- Modal Start-->
<div class="modal fade" id="myModal" role="dialog">
 <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <div class="title-default-bold mb-none">Login</div>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
             <form class="login-form">
                 <input class="main-input-box" type="text" placeholder="User Name" />
                 <input class="main-input-box" type="password" placeholder="Password" />
                 <div class="inline-box mb-5 mt-4">
                     <div class="checkbox checkbox-primary">
                         <input id="modal-checkbox" type="checkbox">
                         <label for="modal-checkbox">Remember Me</label>
                     </div>
                     <label class="lost-password"><a href="#">Lost your password?</a></label>
                 </div>
                 <div class="inline-box mb-5 mt-4">
                     <button class="btn-fill" type="submit" value="Login">Login</button>
                     <a href="#" class="btn-register"><i class="fas fa-user"></i>Register Here!</a>
                 </div>
             </form>
             <label>Login connect with your Social Network</label>
             <div class="login-box-social">
                 <ul>
                     <li><a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
                     <li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
                     <li><a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                     <li><a href="#" class="google"><i class="fab fa-google-plus-g"></i></a></li>
                 </ul>
             </div>
         </div>
     </div>
 </div>
</div>