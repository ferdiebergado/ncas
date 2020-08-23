@foreach ($competencies as $competency)
<tr>
    <td style="width: 5%; text-align: center;">{{ $competency->id }}</td>
    <td style="width: 50%">{{ $competency->title }}</td>
    <td style="width: 10%; text-align: center">{{ $competency::LEVELS[$competency->level_id] }}</td>
    <td style="width: 35%;">{{ $competency::CATEGORIES[$competency->category_id] }}</td>
</tr>
@endforeach
