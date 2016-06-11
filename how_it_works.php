<?php session_start();if(isset($_GET[ "msg"])){if($_GET[ "msg"]=="logout" ){$msg="You have been logged out successfully." ;};}else{$msg=null;}if(isset($_SESSION[ "email"])&&$_SESSION[ "email"]!="" ){header( 'Location:feeds');}else{?>
<!DOCTYPE html>
<html>

<head>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel=stylesheet type=text/css>
    <title>Handybooks: the best place to exchange used books</title>
    <meta charset=utf-8>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="msvalidate.01" content="3A25FDB84BB4A3E4ED6971C368D64986" />
    <meta name="description" content="Buy, sell, donate or exchange second hand books. Exchanging used books was never so easy.">
    <link rel="shortcut icon" href=favicon.ico type=image/x-icon />
    <link rel=stylesheet href=bootstrap.min.css>
    <link rel=stylesheet href=http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css>
    <link rel=stylesheet href=styles/style_default.css>
    <link rel=stylesheet href=styles/style_animate.css>
    <link rel=stylesheet href=jquery.pagepiling.css>
    <style type=text/css>
        @media screen and (max-width: 600px) {
            #pp-nav {
                display: none
            }
        }
        @media screen and (max-width: 350px) {
            .logo_text {
                font-size: 28px
            }
            .pagepiling {
                padding-top: 50px
            }
        }
        .tagline {
            font-family: 'Open Sans', sans-serif
        }
    </style>
    <script src=jquery-1.11.2.min.js></script>
    <script src=bootstrap.min.js></script>
    <script src=jquery.pagepiling.min.js></script>
    <noscript>
        <style type=text/css>
            .pagecontainer {
                display: none
            }
        </style>
        <div style="padding:10px;display:block;width:60%;border:2px solid #eee;border-radius:5px;margin-top:20px;margin-left:auto;margin-right:auto" class=well>
            <div style=margin-left:auto;margin-right:auto></div>
            <div style=display:block;margin-left:auto;margin-right:auto> <img src=images/logo_full.png> </div>
            <hr>
            <div style=color:#DB1F2D>
                <h3>Handybooks loves JavaScript! It can't live without it.</h3>
            </div>
            <div class=noscriptmsg style=color:black;text-align-center;padding:5px> For using this site it is necessary to enable JavaScript and reload.
                <br> <a href=http://www.enable-javascript.com/ target=_blank> Click here for help.</a> </div>
        </div>
    </noscript>
    <script>
        $(document).ready(function() {
            $("#pagepiling").pagepiling({
                menu: "null",
                direction: "vertical",
                verticalCentered: true,
                sectionsColor: [],
                anchors: ["page1", "page2", "page3", "page4"],
                scrollingSpeed: 700,
                easing: "swing",
                loopBottom: true,
                loopTop: true,
                css3: true,
                navigation: {
                    textColor: "#000",
                    bulletsColor: "#000",
                    position: "left",
                    tooltips: ["", "", "", ""]
                },
                normalScrollElements: null,
                normalScrollElementTouchThreshold: 5,
                touchSensitivity: 5,
                keyboardScrolling: true,
                sectionSelector: ".section",
                animateAnchor: true,
                onLeave: function(b, a, c) {},
                afterLoad: function(b, a) {},
                afterRender: function() {},
            })
        });
    </script>
</head>

<body>
    <div class=pagecontainer>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class=container-fluid>
                <div class=navbar-header>
                    <button type=button class=navbar-toggle data-toggle=collapse data-target=#myNavbar> <span class=icon-bar></span> <span class=icon-bar></span> <span class=icon-bar></span> </button> <a href=home onmouseover="document.getElementById('in').style.visibility='visible'" onmouseout="document.getElementById('in').style.visibility='hidden'" class=logo_text><strong>handybooks</strong><small id=in style=visibility:hidden>.in</small></a> </div>
                <div class="collapse navbar-collapse" id=myNavbar>
                    <ul class="nav navbar-nav navbar-right"> 
                    <!-- <a href=post_a_book class="btn btn-primary navbar-btn navbar-left" style=margin-right:5px>Sell a Book</a> -->
                        <li class=dropdown> <a class=dropdown-toggle data-toggle=dropdown href=# aria-expanded=false aria-has-popup=true role=button><i class="fa fa-user"></i> Sign In<span class=caret></span></a>
                            <ul class=dropdown-menu>
                                <li class=dropdown-header>Existing User</li>
                                <li><a href=login>Log In</a>
                                </li>
                                <li class=divider></li>
                                <li class=dropdown-header>New User</li>
                                <li><a href=signup>Register</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id=pagepiling>
            <div class="section section_1 row text-center">
                <div class=row>
                    <div class="animated bounce">
                        <div class="col-md-4 col-md-offset-4"> <img src=images/logo.png class="img-responsive" style=margin-left:auto;margin-right:auto;> <span class=logo_text><strong>handybooks</strong><small>.in</small></span> </div>
                    </div>
                </div>
                <div class="tagline row">
                    <div class="text_uppercase col-md-8 col-md-offset-2 col-sm-12">
                        <h1>the best place for used books exchange</h1>
                    </div>
                </div>
                <br>
                <div class=row>
                    <div class="col-md-4 col-md-offset-4">
                        <div id="section_one_icons center"> <i class="fa fa-leanpub fa-5x"></i>&nbsp;&nbsp; <i class="fa fa-files-o fa-5x"></i>&nbsp;&nbsp; <i class="fa fa-newspaper-o fa-5x"></i>&nbsp;&nbsp; <i class="fa fa-book fa-5x"></i> </div>
                        <div style="margin-top:20px;border:2px solid #1b8b5d;padding:1px 5px 3px 5x;border-radius:10px">
                            <h3 class=text_uppercase> <a href=feeds>BUY</a> | <a href=post_a_book>SELL</a> | <a href=post_a_book>DONATE</a> | <a href=feeds>EXCHANGE</a><br> </h3> </div>
                    </div>
                </div>
                <br>
                <br>
                <div class=row>
                    <div class="center bottom_90"> <a href=#page2 class=next><i class="fa fa-2x fa-arrow-circle-o-down"></i></a> </div>
                </div>
            </div>
            <div class="section section_2 row text-right">
                <div class=col-md-9> <i class="fa fa-newspaper-o fa-5x"></i>&nbsp;&nbsp;<i class="fa fa-book fa-5x"></i>
                    <h1 class=tagline>Sell your used books easily</h1>&nbsp;
                    <h3><span class=focus2>More</span> Buyers, <span class=focus2>Better</span> prices.<br><span class=tagline>Don't give your used books to the kabadiwala anymore.<br>Let it serve the purpose it is meant to.<br>What is useless to you can be of great value to others.</span></h3> </div>
                <div class=col-md-3> </div>
                <div class=row>
                    <div class="center bottom_90"> <a href=#page3 class=next><i class="fa fa-2x fa-arrow-circle-o-down"></i></a> </div>
                </div>
            </div>
            <div class="section section_3 row text-left">
                <div class="col col-md-2"> </div>
                <div class="col col-md-10"> <i class="fa fa-leanpub fa-5x"></i>&nbsp;&nbsp;&nbsp; <i class="fa fa-search fa-5x"></i>
                    <h1 class=tagline>Search and buy old books easily</h1>
                    <h3>We aim to help you find books within your reach.<br>Choose book sellers and buyers from <span class=focus3>locality</span>, or in your <span class=focus3>College</span></h3> </div>
                <div class=row>
                    <div class="center bottom_90"> <a href=#page4 class=next><i class="fa fa-2x fa-arrow-circle-o-down"></i></a> </div>
                </div>
            </div>
            <div class="section section_4 row text-center"> <i class="fa fa-user-secret fa-5x"></i>&nbsp;<i class="fa fa-exchange"></i>&nbsp;&nbsp;<i class="fa fa-user-secret fa-5x"></i>
                <br>
                <h1 class=tagline>Chat directly with your buyers or sellers</h1>
                <br>
                <h4>So you need not worry about sharing your phone number anymore.<br><br>Your privacy is our Priority</h4>
                <br>
                <br>
                <div class=row> <a href="home" class="tagline btn btn-lg btn-primary" id=get_started_btn><b>Explore Handybooks</b></a> </div>
                <br>
                <br>--or--
                <br>
                <br>
                <div class="row bottom_95"> <a href="signup" class="tagline btn btn-lg btn-success" id="get_started_btn">Signup and Get Started</a> </div>
                <center>
                    <footer class=bottom_95>
                        <ul>
                            <li><a href=<?php echo htmlspecialchars( 'about_us');?>>:: About Us ::</a>
                            </li>
                            <li><a href=<?php echo htmlspecialchars( 'our_story');?>>Our Story ::</a>
                            </li>
                            <li><a href=<?php echo htmlspecialchars( 'terms');?>>Terms ::</a>
                            </li>
                            <li><a href=<?php echo htmlspecialchars( 'privacy');?>>Privacy Policy ::</a>
                            </li>
                        </ul>
                    </footer>
                </center>
            </div>
        </div>
    </div>
</body>

</html>
<?php }?>