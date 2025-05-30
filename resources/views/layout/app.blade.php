<!DOCTYPE html>
<html lang="pt-br">
    <head>
        @include("layout.head")
        @yield("styles")
    </head>
    <body class="blank-page">
        @yield("content")
        @include("layout.footer")
        @yield("scripts")
    </body>
</html>
