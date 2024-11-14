@extends('layouts.app')

{{--TODO: needs authentication --}}
@section('title', 'Admin Panel')

@section('content')
    <a class="btn btn-primary" href="{{ route('url.create') }}">Shorten Link</a>
    <br><br>
    @if(count($urls) === 0)
        <h3>No Data</h3>
    @else
    <table class="table">
        <thead class="table table-hover">
        <tr>
            <th scope="col">Short Link</th>
            <th scope="col">Original Link</th>
            <th scope="col">Expiration Date</th>
            <th scope="col">Visit Count</th>
            <th scope="col">Last Visited</th>
        </tr>
        </thead>
        <tbody>
        @foreach($urls as $url)
            <tr>
                <td>
                    <div class="row">
                        <a class="nav-link col" href="{{ route('url.show', ['shortCode' => $url->short_code]) }}">
                            {{ route('url.redirect', ['shortCode' => $url->short_code]) }}
                        </a>
                        <button class="btn btn-secondary btn-sm col" onclick="copyUrl(this)" >
                            <i class="bi bi-copy"></i>
                        </button>
                    </div>
                </td>
                <td>{{ $url->original_url }}</td>
                <td>{{ $url->expire_at }}</td>
                <td>{{ $url->visit_count }}</td>
                <td>{{ $url->last_visited_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        function copyUrl(button) {
            const closestAnchor = button.closest('tr').querySelector('a');

            if (closestAnchor) {
                const url = closestAnchor.text;
                navigator.clipboard.writeText(url)
                    .then(() => {
                        alert('URL copied to clipboard!');
                    })
                    .catch(err => {
                        console.error('Failed to copy URL:', err);
                    });
            }
        }
    </script>
@endsection
