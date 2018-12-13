<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style type="text/css">
    .login-container{
    margin-top: 5%;
    margin-bottom: 5%;
}
.login-form-1{
    padding: 5%;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-1 h3{
    text-align: center;
    color: #333;
}
.login-form-2{
    padding: 5%;
    background: #0062cc;
    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
}
.login-form-2 h3{
    text-align: center;
    color: #fff;
}
.login-container form{
    padding: 10%;
}
.btnSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    border: none;
    cursor: pointer;
}
.login-form-1 .btnSubmit{
    font-weight: 600;
    color: #fff;
    background-color: #0062cc;
}
.login-form-2 .btnSubmit{
    font-weight: 600;
    color: #0062cc;
    background-color: #fff;
}
.login-form-2 .ForgetPwd{
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}
.login-form-1 .ForgetPwd{
    color: #0062cc;
    font-weight: 600;
    text-decoration: none;
}
.help-block{
    color: red;
}
</style>
<?php      
        if(isset($_COOKIE['setEmail'])){
            $strEmail    = $_COOKIE['setEmail'];
            $strPassword = base64_decode(base64_decode($_COOKIE['setPassword']));
            $chkRememberMe = '1';
       }else{
            $strEmail = $strPassword = '';
            $chkRememberMe = '0';
       }
       ?>
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form-1">
            <h3><b>Login</b></h3>
            <form action="" method="post" onsubmit="return checkLogin(this)" action="{{ route($modulePath.'.index') }}" >
                @csrf
                <div class="form-group error">
                    <input type="email" class="form-control" name="txtEmail" id="txtEmail" placeholder="Your Email *" value="{{$strEmail}}" />
                    <span class="error_txtEmail help-block"></span>
                </div>
                <div class="form-group error">
                    <input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Your Password *" value={{$strPassword}}" />
                    <span class="error_txtPassword help-block"></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Login" />
                </div>
                <div class="form-group">
                    <!-- <a href="#" class="ForgetPwd">Forget Password?</a> -->
                    <input type="checkbox" name="chkRememberMe" <?php if($chkRememberMe == '1')echo 'checked'; ?>> Remember Me
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/auth/login/adminCheck.js') }}"></script>