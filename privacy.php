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
            <a href=home onmouseover="document.getElementById('in').style.visibility='visible'" onmouseout="document.getElementById('in').style.visibility='hidden'" class=logo_text>
                <strong>handybooks</strong>
                <small id=in style=visibility:hidden>.in</small>
            </a>
        </div>
        <div class="collapse navbar-collapse" id=myNavbar>
            <ul class="nav navbar-nav navbar-right" style=margin-right:20px>
                <li>
                    <a href="about_us">About Us</a>
                </li>
                <li>
                    <a href="our_story">The Story</a>
                </li>
                <li>
                    <a href="terms">Our Terms</a>
                </li>
                <li class="active">
                    <a href="privacy">Privacy Policy</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id=section4 class="jumbotron" style="height:100vh;margin:0">
        <div class="container">
            <h1 class="open_sans">Privacy Policy</h1> This Privacy Policy was last modified on 20th August 2015.
            <br>
            <br>This page informs you of our policies regarding the collection, use and disclosure of Personal Information we receive from users of the Site. We use your Personal Information only for providing users a personalised experience and improving the Site. By using the Site, you agree to the collection and use of information in accordance with this policy.
            <br>
            <strong class="underliner open_sans">Information Collection And Use.</strong>
            <br> While using our Site, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to your name ("Personal Information") and email-id.
            <br>
            <strong class="underliner open_sans">Log Data</strong>
            <br> Like many site operators, we collect information that your browser sends whenever you visit our Site ("Log Data"). This Log Data may include information such as your computer's Internet Protocol ("IP") address, browser type, browser version, the pages of our Site that you visit, the time and date of your visit, the time spent on those pages and other statistics.
            <br>
            <strong class="underliner open_sans">Cookies</strong>
            <br> Cookies are files with small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer's hard drive. Like many sites, we use "cookies" to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site.
            <br>
            <strong class="underliner open_sans">Security</strong>
            <br> The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.
            <br>
            <strong class="underliner open_sans">Changes To This Privacy Policy</strong>
            <br> We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on the Site. You are advised to review this Privacy Policy periodically for any changes.
            <br>
            <strong class="underliner open_sans">Contact Us</strong>
            <br> If you have any questions about this Privacy Policy, please
            <a onclick=contact_us() onmousehover=contact_us() style=text-decoration:underline>contact us</a>.
            <span id="contact_us" style=display:none;>support@handybooks.in</span>
        </div>
    </div>

</body>

</html>