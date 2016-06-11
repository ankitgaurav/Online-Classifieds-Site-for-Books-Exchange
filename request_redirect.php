<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Handybooks.in - Best place to buy, sell, donate or exchange used/ second-hand books</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="description"   content="Buy, Sell, Donate and Exchange second hand easily in Handybooks.in. You can sell your old books or buy a second hand book easily with handybooks.in " />
    <meta property="og:url"           content="http://www.handybooks.in/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="The best place to exchange second hand books" />
    <meta property="og:description"   content="Buy, Sell, Donate and Exchange second hand easily in Handybooks.in. You can sell your old books or buy a second hand book easily with handybooks.in " />
    <meta property="og:image"         content="http://handybooks.in/images/logo.png" />
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="styles/default_lp.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
    <style type="text/css">
        .post_icons{
            color:#888888;
        }
    	.cta_btns{
    		min-width:250px;
    	}
        .tagline{
            font-family: 'Open Sans', sans-serif;
            }
        #mast_head{
            background: url(images/mast_head1.jpg) no-repeat;
            background-size: cover;

        }
        #hints{
            background-color: white;
            border: 1px #CCCCCC solid;
            border-radius: 5px;
            position: absolute;
        }
        a .txt_decor_no hover{
            text-decoration: none;
        }
        .browse-buttons{
            margin: 3px;
            border-color: #A9D8B2;
        }
        .browse-buttons:hover{
            background-color: #E9F2EB;
        }
        .browse-buttons:active{
            background-color: #E9F2EB !important;
        }
    </style>
    <script>
function on_m_dn(){
document.getElementById("password").type = "text";
}
function on_m_up(){
document.getElementById("password").type = "password";
}

        function save_user_info(){
                var name = edit_form.name.value;
                var institution = edit_form.institution.value;                
                var city = edit_form.city.value;
                var feeds = "feeds";
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("modal-body").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('POST', 'process_save_user_info.php?name='+name+'&institution='+institution+'&city='+city+'&from='+feeds, true);
                xmlhttp.send();
            }

            function showLatestPosts(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        document.getElementById("latest_posts_div").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('POST', 'process_show_latest_posts.php', true);
                xmlhttp.send();
            }
    </script>
    </head>
    <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=410824605770189";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
       <nav class="navbar navbar-default" style="margin-bottom:0;   ">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                    <a href="home" onmouseover = "document.getElementById('in').style.visibility='visible'" onmouseout = "document.getElementById('in').style.visibility='hidden'" class="logo_text">
                        <strong>handybooks</strong>
                        <small id="in" style="visibility:hidden;">.in</small>
                    </a>
            </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
            <!--<a href="post_a_book" class="btn btn-primary navbar-btn navbar-left" style="margin-right:5px;" id="post_ad_btn">Sell a Book</a>-->
            <li>
                <a href="how_it_works">How it Works</a>
            </li>
            <!--<li>
                <a href="#content">Browse</a>
            </li>-->
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" aria-has-popup="true" role="button"><i class="fa fa-user"></i> Sign In<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Existing User</li>
                <li><a href="login">Log In</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">New User</li>
                <li><a href="signup">Register</a></li>
              </ul>
            </li>
            </ul>
        </div>
        </div>
        </nav>
    </body>
</html>

<?php
}
?>