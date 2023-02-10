<html>
<head>
    <!--
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>

        * { font-family: DejaVu Sans, sans-serif; }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid gray;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th></th>
            <th colspan="3">Készülék</th>
            <th>Gyártás</th>
            <th colspan="4">Ellenőrzések</th>
            <th>Megjegyzés</th>
        </tr>
        <tr>
            <th></th>
            <th>Gyári száma</th>
            <th>Készenlét helye</th>
            <th>Tpusa</th>
            <th></th>
            <th>I.</th>
            <th>II.</th>
            <th>III.</th>
            <th>IV.</th>
            <th></th>
        </tr>
        @foreach ($posts as $index => $post)
            <tr class="post">
                <td>{{ $index }}</td>

                <td>{{ $post['fa_no'] }}</td>
                <td>{{ $post['name'] }}</td>
                <td>{{ $post['extinguisher_type']['name'] }}</td>
                <td>{{ $post['fa_date'] }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $post['comment'] }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

