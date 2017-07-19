<!DOCTYPE html>
<html>

<head>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel=stylesheet type=text/css>
    <title>Handybooks: the best place to exchange used books</title>
    <meta charset=utf-8>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href=favicon.ico type=image/x-icon />
    <link rel=stylesheet href=bootstrap.min.css>
    <link rel=stylesheet href=http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css>
    <script src=jquery-1.11.2.min.js></script>
    <script src=bootstrap.min.js></script>
    <style type=text/css>
        .open_sans {
            font-family: 'Open Sans', sans-serif
        }
        .sections {
            margin: 0
        }
        .founder_image {
            width: 150px;
            height: 150px;
            padding-left: auto;
            padding-right: auto
        }
        .founder_info {
            text-align: center
        }
        .img_center {
            margin-right: auto;
            margin-left: auto
        }
        .underliner {
            text-decoration: underline
        }
        .footer {
            background: transparent;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            left: 0
        }
        @font-face {
            font-family: LimeLight-Regular;
            src: url(styles/Limelight-Regular.ttf)
        }
        .logo_text {
            margin-left: 10px;
            font-family: LimeLight-Regular;
            font-size: 35px;
            text-decoration: none;
            color: #4a47be
        }
        .logo_text:hover {
            color: #4a47be
        }
        a.logo_text {
            text-decoration: none
        }
    </style>
    <script type=text/javascript>
        function contact_us() {
            document.getElementById("contact_us").style.display = "inline-block"
        };
    </script>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class=navbar-header>
            <button type=button class=navbar-toggle data-toggle=collapse data-target=#myNavbar>
                <span class=icon-bar></span>
                <span class=icon-bar></span>
                <span class=icon-bar></span>
            </button>
            <a href=index.php onmouseover="document.getElementById('in').style.visibility='visible'" onmouseout="document.getElementById('in').style.visibility='hidden'" class=logo_text>
                <strong>handybooks</strong>
                <small id=in style=visibility:hidden>.in</small>
            </a>
        </div>
        <div class="collapse navbar-collapse" id=myNavbar>
            <ul class="nav navbar-nav navbar-right" style=margin-right:20px>
                <li class="active">
                    <a href="about_us.php">About Us</a>
                </li>
                <li>
                    <a href="our_story.php">The Story</a>
                </li>
                <li>
                    <a href="terms.php">Our Terms</a>
                </li>
                <li>
                    <a href="privacy.php">Privacy Policy</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id=section1 class=jumbotron style=height:100%;margin:0>
        <div class=container>
            <h1 class=open_sans>About Us</h1>
            <br>
            <div class=row>
                <div class=col-md-7>
                    <div class=row>
                        <br>
                        <div class=container>
                            <p> Handybooks.in is a one-of-its-kind website dedicated to helping students and book-lovers exchange their used books with ease.
                                <br>
                                <br>We believe that books are far more like an asset to the mankind than being mere a collection of papers.
                                <br>So instead of giving away your unwanted books to the local
                                <i>kabadi</i>, post it here.
                                <br>Who knows someone might need that one book to get enlightened.
                                <br>
                                <br> Through Handybooks, we assure that you no longer visit some distant second hand marketplace to buy or sell a used book.
                                <br>We want to make sharing knowledge easier and far less expensive.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-1">
                    <div class=row>
                        <div class=container>
                            <div class=col-md-6>
                                <div class=row>
                                    <img src=images/anku.jpg class="img_center founder_image responsive img-circle img-thumbnail">
                                    <span class="founder_name open_sans">
                                                                                                            <h4>Ankit Gaurav</h4>
                                                                                                        </span>
                                    <span class=founder_designation>Co-Founder</span>
                                </div>
                            </div>
                            <div class=col-md-6>
                                <div class=row>
                                    <img src=images/raju.jpg class="img_center founder_image responsive img-circle img-thumbnail">
                                    <span class="founder_name open_sans">
                                                                                                                <h4>Raj Vaibhav Singh</h4>
                                                                                                            </span>
                                    <span class=founder_designation>Co-Founder</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <br> We are a team of two web developers based in Kolkata who are always keen to seek out for existing problems in the society and love to come out with simple solutions to them.
                        <br>
                    </div>
                    <hr>
                    <div class=row> You can also check out our page on Facebook.
                        <br>We promise you will like that too.
                        <i class="fa fa-smile-o"></i>
                        <a href=http://www.facebook.com/handybooks>
                            <i class="pull-right fa fa-facebook-official fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
