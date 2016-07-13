<!DOCTYPE html>
<html lang="en">

    <head>

        <!-- meta tag -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="3600" />
        <meta name="revisit-after" content="2 days" />
        <meta name="robots" content="index,follow" />
        <meta name="author" content="Designed by Glingegneri / Gioacchino Castorio, Antonio Tuzi, Alessandro Calderoni & Doppio Mareino" />
        <meta name="distribution" content="global" />
        <meta name="description" content="Your container description here" />
        <meta name="keywords" content="Your keywords, keywords, keywords, here" />

        <!-- fogli di stile -->
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/dashboard.css" />
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/jquery-ui.min.css" />
        {foreach $style as $css}
        <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./templates/template/css/{$css}.css" />
        {foreachelse}
            <!-- no css -->
        {/foreach}

        <!-- script js -->
        <script src="./js/libs/jquery-3.0.0.min.js"></script> <!-- jquery 3.0.0 -->
        <script src="./js/libs/jquery-ui.min.js"></script> <!-- jquery UI -->
        <script src="./js/libs/manage_url.js"></script> <!-- jquery UI -->
        <script src="./js/libs/handlebars-v4.0.5.js"></script> <!-- handlebars -->
        <script src="./js/libs/jquery.cookie.js"></script> <!-- handlebars -->

        {foreach $js as $script}
        <script src="./js/opt/{$script}.js"></script>
            {foreachelse}
            <!-- no other js -->
        {/foreach}

        <title>{$title}</title>

        <!-- ?id=1&env=image&op=aux_pic -->
        <link rel="icon" type="image/jpeg" href="./?id=3&env=image&op=aux_pic" />
    </head>

        <!-- qui inizia il body -->

    <body>
        {$body_content}
    </body>
</html>