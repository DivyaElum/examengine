<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
    .register{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    margin-top: 3%;
    padding: 3%;
}
.register-left{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}
.register-left input{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}
.register-right{
    background: #f8f9fa;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
}
.register-left img{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}
@-webkit-keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}
.register-left p{
    font-weight: lighter;
    padding: 12%;
    margin-top: -9%;
}
.register .register-form{
    padding: 10%;
    margin-top: 10%;
}
.btnRegister{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}
.register .nav-tabs{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}
.register .nav-tabs .nav-link{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}
.register .nav-tabs .nav-link:hover{
    border: none;
}
.register .nav-tabs .nav-link.active{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}
.register-heading{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}
.has-error{
    color: red;
}
</style>
<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>Welcome</h3>
            <p>You are 30 seconds away from earning your own money!</p>
            <input type="submit" name="" value="Login"/><br/>
        </div>
        <div class="col-md-9 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form name="frmRegistration" id="frmRegistration" onsubmit="return saveMember(this)" action="{{ route($modulePath.'.index') }}" method="post">
                        <h3 class="register-heading">Registration</h3>
                        <div class="row register-form">
                            @csrf
                            <div class="col-md-8">
                                <div class="form-group error">
                                    <input type="text" class="form-control" name="txtFirstName" id="txtFirstName" placeholder="First Name *" value="" />
                                    <span class="error_txtFirstName help-block"></span>
                                </div>
                                <div class="form-group error">
                                    <input type="text" class="form-control" name="txtLastName" id="txtLastName" placeholder="Last Name *" value="" />
                                    <span class="error_txtLastName help-block "></span>
                                </div>
                                <div class="form-group error">
                                    <input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Password *" value="" />
                                    <span class="error_txtPassword help-block"></span>
                                </div>
                                <div class="form-group error">
                                    <input type="password" class="form-control"  name="txtComfirmPassword" id="txtComfirmPassword" placeholder="Confirm Password *" value="" />
                                    <span class="error_txtComfirmPassword help-block"></span>
                                </div>
                                <div class="form-group error">
                                    <input type="email" class="form-control" placeholder="Your Email *" name="email" id="email" value="" />
                                    <span class="error_email help-block"></span>
                                </div>

                                <div class="form-group error">
                                    <input type="text" minlength="10" maxlength="10" name="txtPhone" id="txtPhone" class="form-control" placeholder="Your Phone *" value="" />
                                    <span class=" error_txtPhone help-block"></span>
                                </div>
                                <input type="submit" class="btnRegister"  value="Register"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/auth/registration/addEditMember.js') }}"></script>
