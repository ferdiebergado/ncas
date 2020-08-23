@extends('components.card')

@section('card-title', 'COMPETENCIES')

@section('card-content')
<div class="colums">
    <div class="column is-clearfix">
        <a href="{{ route('competencies.create') }}" class="button is-success is-pulled-right">NEW</a>
    </div>
</div>
<div class="columns">
    <div class="column">
        <div class="table-container">
            <table class="table is-stdiped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Category</th>
                        <th class="is-centered" colspan="3">Task(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($competencies as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item::LEVELS[$item->level_id] }}</td>
                        <td>{{ $item::CATEGORIES[$item->category_id] }}</td>
                        <td><a href="{{ route('competencies.show', $item) }}">View </a><a
                                href="{{ route('competencies.edit', $item) }}">Edit </a><a
                                href="{{ route('competencies.destroy', $item) }}">Delete</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td>No data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
