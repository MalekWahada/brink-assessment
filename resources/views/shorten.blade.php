@extends('layouts.app')

@section('title', 'Shorten Link')

@section('content')
    <form method="POST" action="{{ route('url.store') }}">
        @csrf
        <div class="mb-3">
            <label for="originalUrl" class="form-label">Link</label>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3">https://app.com/users/</span>
                <input type="url" class="form-control" name="originalUrl" aria-describedby="basic-addon3 basic-addon4" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="expireAt" class="form-label">Set Expiration:</label>
            <select name="expireAt" id="expireAt" class="form-select" onchange="toggleCustomExpiration()" required>
                <option value="24_hours">24 Hours</option>
                <option value="7_days">7 Days</option>
                <option value="custom">Custom</option>
            </select>
        </div>

        <div class="mb-3" id="customExpirationDiv"  style="display: none;">
            <input type="datetime-local" name="customExpiration" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Shorten Link</button>
    </form>
@endsection

@section('scripts')
    @parent
    <script>
        function toggleCustomExpiration() {
            const expireAt = document.getElementById("expireAt").value;
            document.getElementById("customExpirationDiv").style.display = expireAt === "custom" ? "block" : "none";
        }
    </script>
@endsection
