<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>

        </style>

    </head>
    <body>
        <div id="app"><App /></div>
    </body>

    <script>
        window.getDate = () => {
            let d = new Date(),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('.');
        }
    </script>

    @vite(['resources/sass/define.sass'])
    @vite(['resources/css/reset.css'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</html>
