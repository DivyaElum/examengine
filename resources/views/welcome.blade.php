@extends('front.master')

@section('title')
    {{ $moduleAction }}
@stop
@section('styles')

@stop

@section('content')

<section class="mainBanner clearfix">
    <div class="social">
        <div class="wrapper">
            <ul class="list-unstyled">
                <li><a href="#" title="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" title="twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" title="pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="#" title="instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
            <span>Follow us on</span>
        </div>
    </div>
    
    <div id="mainBannerSlider" class="owl-carousel owl-theme">
      <div class="owl-slide d-flex align-items-center cover" style="background-image: {{asset('images/homepage/banner-img1.jpg')}}">
        <div class="container">
          <div class="row justify-content-center justify-content-md-start">
            <div class="col-10 col-md-6 static">
              <div class="owl-slide-text">
                <h2 class="owl-slide-animated owl-slide-title"><span>MSC Partner</span> Network</h2>
                <div class="owl-slide-animated owl-slide-subtitle mb-3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </div>
                <a class="btn owl-slide-animated owl-slide-cta" href="#">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </div><!--/owl-slide-->
  
      <div class="owl-slide d-flex align-items-center cover" style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/owlcarousel1.jpg);">
        <div class="container">
          <div class="row justify-content-center justify-content-md-start">
            <div class="col-10 col-md-6 static">
              <div class="owl-slide-text">
                <h2 class="owl-slide-animated owl-slide-title"><span>MSC Partner</span> Network</h2>
                <div class="owl-slide-animated owl-slide-subtitle mb-3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </div>
                <a class="btn owl-slide-animated owl-slide-cta" href="#">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </div><!--/owl-slide-->

      <div class="owl-slide d-flex align-items-center cover" style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/owlcarousel2.jpg);">
        <div class="container">
          <div class="row justify-content-center justify-content-md-start">
            <div class="col-10 col-md-6 static">
              <div class="owl-slide-text">
                <h2 class="owl-slide-animated owl-slide-title"><span>MSC Partner</span> Network</h2>
                <div class="owl-slide-animated owl-slide-subtitle mb-3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </div>
                <a class="btn owl-slide-animated owl-slide-cta" href="#">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </div><!--/owl-slide-->

      <div class="owl-slide d-flex align-items-center cover" style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/owlcarousel3.jpg);">
        <div class="container">
          <div class="row justify-content-center justify-content-md-start">
            <div class="col-10 col-md-6 static">
              <div class="owl-slide-text">
                <h2 class="owl-slide-animated owl-slide-title"><span>MSC Partner</span> Network</h2>
                <div class="owl-slide-animated owl-slide-subtitle mb-3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </div>
                <a class="btn owl-slide-animated owl-slide-cta" href="#">Contact Us</a>
              </div>
            </div>
          </div>
        </div>
      </div><!--/owl-slide-->
    </div>
    <div class="container newsletterForm_wrap">
        <div class="newsletterForm">
        <form name="frmNewslatter" id="frmNewslatter" onsubmit="return saveNewsletter(this)" action="{{ url('/newsletter') }}"  method="post">
                @csrf
                <h2><span>Sign up for our </span>newsletter!</h2>
                <div class="alert alert-success alert-dismissible successMsgAlrt">
                    <strong><span class="successMessage"></span></strong>
                </div>
                <div class="alert alert-danger alert-dismissible errorMsgAlrt">
                    <strong><span class="dangerMessage"></span></strong>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email Address" required="" >
                </div>
                <div class="form-group">
                    <img src="{{asset('images/captcha-img.png')}}" class="img-responsive" alt="">
                </div>
                
                <button type="submit" class="btn btn-default" id="btnSumit">Sign Up Now</button>
            </form>
        </div>
    </div>
</section>
<!-- END - Main Banner -->

<section class="bodyContent clearfix">
    <div class="container-fluid text-center">
        <h1 class="heading1">Find services or certificational courses for you.</h1>
        <div id="servicesCarousel" class="owl-carousel owl-theme">
            <div>
                <div class="card">
                    <div class="title" style="background-image: {{asset('images/certification_lists/course_img1.jpg')}}">
                        <div class="titleWrap">
                            <h3>MSP & Cloud Insurance</h3>
                            <span class="icon"></span>
                        </div>
                    </div>
                    <div class="cardContent">
                        <h2 class="price"><span>$85.00</span> $79.50</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur venenatis blandit. Praesent vehicula, libero non pretium vulputate, lacus arcu facilisis lectus, sed feugiat tellus nulla eu dolor. Nulla porta bibendum lectus quis euismod. Aliquam volutpat ultricies porttitor. Cras risus nisi, accumsan vel cursus ut, sollicitudin vitae dolor. Fusce scelerisque eleifend lectus in bibendum. Suspendisse lacinia egestas felis a volutpat.</p>
                        <a href="#" class="btnArrow"><span></span></a>
                    </div>
                </div>              
            </div>
            <div>
                <div class="card">
                    <div class="title" style="background-image: {{asset('images/certification_lists/course_img1.jpg')}}">
                        <div class="titleWrap">
                            <h3>MSP & Cloud Insurance</h3>
                            <span class="icon"></span>
                        </div>
                    </div>
                    <div class="cardContent">
                        <h2 class="price"><span>$85.00</span> $79.50</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur venenatis blandit. Praesent vehicula, libero non pretium vulputate, lacus arcu facilisis lectus, sed feugiat tellus nulla eu dolor. Nulla porta bibendum lectus quis euismod. Aliquam volutpat ultricies porttitor. Cras risus nisi, accumsan vel cursus ut, sollicitudin vitae dolor. Fusce scelerisque eleifend lectus in bibendum. Suspendisse lacinia egestas felis a volutpat.</p>
                        <a href="#" class="btnArrow"><span></span></a>
                    </div>
                </div>              
            </div>
            <div>
                <div class="card">
                    <div class="title" style="background-image: {{asset('images/certification_lists/course_img1.jpg')}}">
                        <div class="titleWrap">
                            <h3>MSP & Cloud Insurance</h3>
                            <span class="icon"></span>
                        </div>
                    </div>
                    <div class="cardContent">
                        <h2 class="price"><span>$85.00</span> $79.50</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur venenatis blandit. Praesent vehicula, libero non pretium vulputate, lacus arcu facilisis lectus, sed feugiat tellus nulla eu dolor. Nulla porta bibendum lectus quis euismod. Aliquam volutpat ultricies porttitor. Cras risus nisi, accumsan vel cursus ut, sollicitudin vitae dolor. Fusce scelerisque eleifend lectus in bibendum. Suspendisse lacinia egestas felis a volutpat.</p>
                        <a href="#" class="btnArrow"><span></span></a>
                    </div>
                </div>              
            </div>
            <div>
                <div class="card">
                    <div class="title" style="background-image: {{asset('images/certification_lists/course_img1.jpg')}}">
                        <div class="titleWrap">
                            <h3>MSP & Cloud Insurance</h3>
                            <span class="icon"></span>
                        </div>
                    </div>
                    <div class="cardContent">
                        <h2 class="price"><span>$85.00</span> $79.50</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur venenatis blandit. Praesent vehicula, libero non pretium vulputate, lacus arcu facilisis lectus, sed feugiat tellus nulla eu dolor. Nulla porta bibendum lectus quis euismod. Aliquam volutpat ultricies porttitor. Cras risus nisi, accumsan vel cursus ut, sollicitudin vitae dolor. Fusce scelerisque eleifend lectus in bibendum. Suspendisse lacinia egestas felis a volutpat.</p>
                        <a href="#" class="btnArrow"><span></span></a>
                    </div>
                </div>              
            </div>
            <div>
                <div class="card">
                    <div class="title" style="background-image: {{asset('images/certification_lists/course_img1.jpg')}}">
                        <div class="titleWrap">
                            <h3>MSP & Cloud Insurance</h3>
                            <span class="icon"></span>
                        </div>
                    </div>
                    <div class="cardContent">
                        <h2 class="price"><span>$85.00</span> $79.50</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur venenatis blandit. Praesent vehicula, libero non pretium vulputate, lacus arcu facilisis lectus, sed feugiat tellus nulla eu dolor. Nulla porta bibendum lectus quis euismod. Aliquam volutpat ultricies porttitor. Cras risus nisi, accumsan vel cursus ut, sollicitudin vitae dolor. Fusce scelerisque eleifend lectus in bibendum. Suspendisse lacinia egestas felis a volutpat.</p>
                        <a href="#" class="btnArrow"><span></span></a>
                    </div>
                </div>              
            </div>
            <div>
                <div class="card">
                    <div class="title" style="background-image: {{asset('images/certification_lists/course_img1.jpg')}} url(images/certification_lists/course_img1.jpg)">
                        <div class="titleWrap">
                            <h3>MSP & Cloud Insurance</h3>
                            <span class="icon"></span>
                        </div>
                    </div>
                    <div class="cardContent">
                        <h2 class="price"><span>$85.00</span> $79.50</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur venenatis blandit. Praesent vehicula, libero non pretium vulputate, lacus arcu facilisis lectus, sed feugiat tellus nulla eu dolor. Nulla porta bibendum lectus quis euismod. Aliquam volutpat ultricies porttitor. Cras risus nisi, accumsan vel cursus ut, sollicitudin vitae dolor. Fusce scelerisque eleifend lectus in bibendum. Suspendisse lacinia egestas felis a volutpat.</p>
                        <a href="#" class="btnArrow"><span></span></a>
                    </div>
                </div>              
            </div>
        </div>
    </div>
    <div class="container welcomeSection">
        <div class="row">
            <div class="col-sm-6">
                <div class="wel_imgSec">
                    <img src="{{asset('images/homepage/welcome_img.png')}}" class="img-responsive" alt="">
                    <span class="yellow-ball bPat"></span>
                    <span class="green-ball bPat"></span>
                    <span class="blue-ball bPat"></span>
                </div>
            </div>
            <div class="col-sm-1 d-sm-none"></div>
            <div class="col-sm-5">
                <h2 class="heading2">Welcome to MSC</h2>
                <p class="highlightedTxt">MSPAlliance began in the year 2000 with the vision of becoming the unified voice for the Managed Services Industry. 
                
                <p>Our goal was to build a global organization for Manage Service (including cloud computing) Professionals where they could network, collaborate and share information. </p>
                
                <p>Today we're over 30,000 members strong and have become a globally recognized standards, certification and consulting body for the Manage Service and Cloud Computing industry. MSPAlliance has always been on the cutting edge of advancing the cause of Cloud Computing and Managed Services Professionals. </p>
                
                <p>Now...What can WE do, for YOU?</p>
                <br>
                <a href="#" class="btn small-btn">Read More</a>
            </div>
        </div>
    </div>
</section>

@stop
@section('scripts')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('/js/front/dashboard/newsletter.js') }}" ></script>
@stop