 <div class="modal fade" id="signOutModal">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content card-primary card-outline">
       <div class="modal-body text-center ">
         <i class="fas fa-info-circle mt-2 text-warning" style="font-size: 100px"></i>
         <div class="card-body text-center">
           Hey! You are about to Sign Out?
         </div>
       </div>
       <div class="modal-footer justify-content-center">
         <!-- Authentication -->
         <form method="POST" action="{{ route('logout') }}">
           @csrf
           <a id="close-modal" type="button" class="btn btn-danger" data-dismiss="modal">No, Stay</a>
           <a class="btn btn-primary"
             href="route('logout')" onclick="event.preventDefault();
          this.closest('form').submit();"> Yes, Sign Out
           </a>
         </form>
       </div>
     </div>
   </div>
 </div>
 <footer class="main-footer">
   <span>&copy; &nbsp;2021-{{ date('Y') }} <a href="#">Investors.club</a>. All Rights Reserved.</span>
   <div class="float-right d-none d-sm-inline-block">&nbsp;</div>
 </footer>