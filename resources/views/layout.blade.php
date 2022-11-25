<!doctype html>
<html lang="en">

<head>
    <title>@yield("title")</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield("description")">
    <meta name="keywords" content="@yield("keywords")">
    <meta name="author" content="Enes Kurbetoğlu">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="{{ asset("assets") }}/css/style.css">
    <script src="https://kit.fontawesome.com/145dc722bb.js" crossorigin="anonymous"></script>
    @yield("styles")
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    @include("_header")

    @section("content")
    @show

    @include("_footer")
    @yield("footerjs")
</body>
</html>