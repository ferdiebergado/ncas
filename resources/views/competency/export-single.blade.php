<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 1rem;
        }

        table {
            table-layout: fixed;
        }

        td {
            padding-bottom: 1rem;
        }

        hr {
            border-style: solid;
            border-color: darkgray;
            border-width: 1px;
        }
    </style>
</head>

<body>
    @inject('competency', 'App\Competency')
    <h3>Competency</h3>
    <hr>
    <table width="100%">
        <tbody>
            <tr>
                <td width="15%">ID:</td>
                <td>{{ $data->id }}</td>
            </tr>
            <tr>
                <td width="15%">Title:</td>
                <td>{{ $data->title }}</td>
            </tr>
            <tr>
                <td width="15%">Level:</td>
                <td>{{ $competency::LEVELS[$data->level_id] }}</td>
            </tr>
            <tr>
                <td width="15%">Category:</td>
                <td>{{ $competency::CATEGORIES[$data->category_id] }}</td>
            </tr>
        </tbody>
    </table>
    <hr>
</body>

</html>
