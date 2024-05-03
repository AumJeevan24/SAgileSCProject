@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create Bugtrack</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('bugtrack.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="severity">Severity:</label>
                                <input type="text" class="form-control" id="severity" name="severity" value="medium">
                            </div>
                            <div class="col">
                                <label for="status">Status:</label>
                                <input type="text" class="form-control" id="status" name="status" value="open">
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="flow">Flow:</label>
                            <input type="text" class="form-control" id="flow" name="flow">
                        </div>
                        <div class="form-group">
                            <label for="expected_results">Expected Results:</label>
                            <textarea class="form-control" id="expected_results" name="expected_results" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="actual_results">Actual Results:</label>
                            <textarea class="form-control" id="actual_results" name="actual_results" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attachment:</label>
                            <input type="text" class="form-control" id="attachment" name="attachment">
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="assigned_to">Assigned To:</label>
                                <input type="text" class="form-control" id="assigned_to" name="assigned_to">
                            </div>
                            <div class="col">
                                <label for="reported_by">Reported By:</label>
                                <input type="text" class="form-control" id="reported_by" name="reported_by">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
