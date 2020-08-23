<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-size: 0.8rem;
        }

        table {
            table-layout: fixed;
            border-collapse: collapse;
        }

        th {
            background: grey;
            border-color: grey;
            border-style: solid;
            border-width: 1px;
            color: azure;
            padding: 5px;
        }

        td {
            border: 1px;
            border-style: solid;
            border-color: black;
            border-width: 1px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h3>COMPETENCIES</h3>

    <table width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Level</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($competencies as $competency)
            <tr>
                <td style="width: 5%; text-align: center;">{{ $competency->id }}</td>
                <td style="width: 50%">{{ $competency->title }}</td>
                <td style="width: 10%; text-align: center">{{ $competency::LEVELS[$competency->level_id] }}</td>
                <td style="width: 35%;">{{ $competency::CATEGORIES[$competency->category_id] }}</td>
            </tr>
            @empty
            <p>No data</p>
            @endforelse
        </tbody>
    </table>
</body>

</html>
