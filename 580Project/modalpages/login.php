<div id="loginmodal" class="modal fade" role="dialog">
<script type="text/javascript" src="../core/jsfunctions/login.js"></script>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" id="loginmodalcontent">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <center><h3 class="modal-title">Log In</h3></center>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="loginform" action="" method="post">
          <div class="form-group">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
             <input type="email" value="" class="form-control" id="inputEmail3" placeholder="Email" name = "username">
            </div>
            <div class="col-sm-1"></div>
          </div>
          <div class="form-group">
           <div class="col-sm-1"></div>
           <div class="col-sm-10">
              <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name = "password">
           </div>
           <div class="col-sm-1"></div>
          </div>
          <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <center><button type="submit" id="loginsubmit" class="btn btn-md btn-primary btn-block">Login</button></center>
                <a href="#registermodal"  id="registerlink" data-toggle="modal">Register</a>
            </div>
            <div class="col-sm-1"></div>
          </div>
          <br>
          <div class="form-group">
            <div class="col-sm-offset-1 col-sm-11">
              <div class="checkbox">
               <label>
                  <input type="checkbox"> Remember me
               </label>
             </div>
           </div>
          </div>
          <div class="row">
            <div class="col-sm-1"></div>
            <div class = "col-sm-10"><div id = "logindialog"></div></div>
            <div class="col-sm-1"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--data-dismiss="modal"-->
      </div>
    </div>
  </div>
</div>