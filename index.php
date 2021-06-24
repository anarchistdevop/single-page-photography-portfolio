<?php

$photos_dir="photos/";
$dirs = array_filter(glob("$photos_dir*"), 'is_dir');
$first_dir=str_replace($photos_dir,"",$dirs[0]);
$nav_menu="";
$carousel=array();
while ($dirs){
        $dir=array_shift($dirs);
        $photos = array_filter(glob("$dir/*.jpg"), 'is_file');
        $nav_element=str_replace($photos_dir,"",$dir);
        $nav_menu .= "<li class=\"nav-item\"> <a class=\"nav-link text-capitalize\" href=\"$nav_element\">$nav_element</a> </li>\n";
        shuffle($photos);
        while ($photos) {
                $photo=array_shift($photos);
                $active = empty($carousel["$nav_element"])?"active":"";

                $size = GetImageSize ($photo, $info);
                $iptc = iptcparse($info['APP13']);
                $title=$iptc['2#005']['0'];
                $description=$iptc['2#120']['0'];

$carousel["$nav_element"] .= <<<HTML
        <div class="carousel-item ${active}">
                <img class="d-block w-100" src="$photo"/>
                <div class="carousel-caption bg-white text-dark m-0 p-0">
                <h5 class="m-0 p-0">${title}</h5>
                <p class="m-0 p-0">${description}</p>
                </div>
        </div>
HTML;
        }
}

$carousel["info"] .= <<<HTML
        <div class="carousel-item active">
                <div class="carousel-item active">
                    <div class="carousel-content">
                        <div>
                                <h3>The boring stuff!</h3>
                                <p>This website is a very basic PHP single page application</p>
                                <p>The unlicense(d) source code for this website can be found at <a href="https://github.com/anarchistdevop/single-page-photography-portfolio">https://github.com/anarchistdevop/single-page-photography-portfolio</a></p>
                    </div>
                </div>
        </div>
HTML;


if ($_SERVER["REQUEST_METHOD"] == "POST") { //POST Request
$req_page = $_POST['page'];
if (!empty($req_page)) {
        if ($req_page=="home"){$req_page = $first_dir;}
print <<<HTML
        <div class="carousel-inner">
                ${carousel["$req_page"]}
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                </a>
        </div>
HTML;
        exit();
}

} else { //GET Request
$req_page = $first_dir;
$page_content= <<<HTML
        <div class="carousel-inner">
                ${carousel["$req_page"]}
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                </a>
        </div>
HTML;
}

print <<<HTML
<!doctype html>
<html lang="en">

<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="assets/jquery/jquery-3.6.0.min.js"></script>
        <link href="assets/fonts/leckerli-one/LeckerliOne.css" rel="stylesheet">
        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <style>
        .leckerli-one {
                font-family: 'Leckerli One';
                font-weight: normal;
                font-style: normal;
        }
        .carousel-caption {
                max-width: 100%;
                width:100%;
                opacity:0.8!important;
                left: 0;
                bottom: 0;
        }
        .carousel-content {
                display:flex;
                height:100%;
                width:100%;
                margin-top: 10%;
                margin-bottom: 10%;
                padding:100px;
        }
        </style>
        <script>
        $(document).ready(function() {
                $("a[role!='button']").click(function() {
                event.preventDefault();
                var name = $(this).attr('href');
                $.post(".", { page: name }, function(result){
                        $("#carousel").html(result); });
                        $("#pagename").html(name);
                        $('title').html(name.substr(0,1).toUpperCase()+name.substr(1));
                });
        });
        </script>
        <title>Sylvester D'Souza</title>
</head>

<body>
        <div class="container-fluid">
                <header class="blog-header">
                        <div class="row flex-nowrap justify-content-center">
                                <div class=" text-center">
                                        <h1><a class="blog-header-logo text-primary text-decoration-none leckerli-one" href="home">Sylvester D'Souza</a></h1> </div>
                        </div>
                </header>

                <div class="nav-scroller">
                        <nav class="nav d-flex justify-content-center text-secondary">
                                <ul class="nav justify-content-center">
                                        ${nav_menu}
                                </ul>
                        </nav>
                </div>

                <main class="container">
                        <div class="jumbotron jumbotron-fluid m-1 p-1">
                        <p id="pagename" class="text-capitalize lead m-1 p-1">${req_page}</p>
                        <div id="carousel" class="carousel slide m-1 p-1" data-ride="carousel">
                                ${page_content}
                        </div>
                        </div>
                </main>
                <footer class="blog-footer">
                        <div class="row flex-nowrap justify-content-center">
                                <div class="p-2 text-center"><a href="info" class="text-decoration-none">Info</a></div>
                        </div>
                </footer>
        </div>
</body>

</html>
HTML;

?>
