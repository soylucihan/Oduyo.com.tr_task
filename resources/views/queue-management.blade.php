@extends('layouts.app')
<container>
    <h1>Queue Management</h1>
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Queue Id</th>
                        <th>Queue</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->queue }}</td>
                        <td>{{ $job->created_at }}</td>
                        <td class="action">
                            <form method="POST" action="/queue-management/cancel/{{ $job->id }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                            <form method="POST" action="/queue-management/re-execute/{{ $job->id }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Re-execute</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <h1>Queue List</h1>
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Queue Id</th>
                        <th>Queue</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->queue }}</td>
                        <td>{{ $job->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</container>
<style>
    .action {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
</style>
