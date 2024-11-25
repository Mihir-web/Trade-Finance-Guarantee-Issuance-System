@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Import Guarantees</h2>
    <form action="{{ route('guaranteeimport') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Select File</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Import</button>
    </form>
</div>
@endsection
