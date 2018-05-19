<!DOCTYPE html>
<html land="en">
    <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Video Upload</title>
      <link rel='stylesheet'  href="css/bootstrap.min.css" />
     <!-- <link rel='stylesheet'  href="css/bootstrap-rtl.css" />   -->
      <link rel='stylesheet'  href="css/font-awesome.min.css" />
      <link rel='stylesheet'  href="css/style.css" />
      <link rel="stylesheet" href="css/skin/skin.css">
      <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">

      <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

      <!--        <link rel='stylesheet'  href="css/rtl.css" />-->
      <!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
       <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
       <![endif]-->
<style type="text/css">
.video-section .video-left{
    display: none;
}
.video-section .video-right{
    margin-left: 5px;
}
.teacher-notes p{
    width:100%;
}
.footer-section {
 /*   background-color: #f7cca0;*/
}
.form_section button{
    margin: 5px 0px;
}
.form_section button a{
     color: #ffff;
    text-decoration: none;
        font-weight: bold;
}

#myOffer h2{
 padding-top: 20px;
}

#myOffer .modal-content , #myOffer .header-login {
 height:auto;

}
.loadr {
    border: 5px solid #f3f3f3;
    border-radius: 50%;
    border-top: 5px solid #3498db;
    width: 40px;
    height: 40px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    margin: 30px 0 0 45%;
}
.about-section{
    width: 100%;
}
.sections li{
 width: 47%;

}
.website-sessions p,.website-sessions .cours-price,.inside-section .cours-price,.inside-section p{
    text-align: left;

}
.clear{
        clear: both;
}
.navbar-default .dropdown ul{
    padding-left: 5px;
}
.sections h3,.nav-tabs>li>a {
    font-weight: bold;
}
.section-inside .section-curse-top i{
    float:right;
    margin-right: 10px;
}
.section-inside .section-curse-top span{
      margin-left: 10px;
}
.sign-up .form_section input{
        padding-left: 10px;
}
.sign-up .form_section  textarea {
    font-family: "Vollkorn", sans-serif;
    padding-left: 10px;
    margin-bottom: 7px;
    border: 2px solid #29d16c;
    background: transparent;
    color: #666;
    width: 100%;
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}

</style>
    </head>
  <body class="<?=(isv("app") != "signup"?(isv("app") != "contact"?"color-gray":""):"")?>">

      <div class="nav_bar">
        <nav class="navbar navbar-default">
          <div class="container">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <img src="images/logo.png" width="150">
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="home.html">Home</a></li>
                  <li><a href="about.html">About</a></li>
                   <li class="dropdown">
                      <a href="category.html" class="dropbtn">Category<span class="caret"></span></a>
                      <ul class="dropdown-content text-left">
                        <li><a href="category1.html">section 1</a></li>
                        <li><a href="category2.html">section 2</a></li>
                        <li><a href="category3.html">section 3</a></li>
                      </ul>
                   </li>
                    <!--<li><a href="articles.html">Blog</a></li>     -->
                  <li><a href="#" data-toggle="modal" data-target="#myModal">Login</a></li>
                      <div id="myModal" class="modal fade text-center" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-body">
                                <div id="content">
                                  <div class="header-login">
                                    <h2>Login</h2>
                                  </div>
                                   <div class="form_section">
                                    <div class="form-group">
                                      <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Username" required="">
                                    </div>
                                    <div class="form-group">
                                      <input type="password" class="form-control" name="email" id="email" placeholder="Password" required="">
                                    </div>
                                    <button>Enter</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                    <li><a href="signup.html">Signup</a></li>
                </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </div>
        </nav>
         </div>