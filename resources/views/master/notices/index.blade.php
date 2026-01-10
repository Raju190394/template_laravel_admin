@extends('layouts.admin')

@section('content')
<div class="container-xxl pt-4 px-4">
    <div class="bg-white rounded h-100 p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0 text-primary">Notice Board Management</h6>
            <a href="{{ route('master.notices.create') }}" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Post New Notice</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Target Audience</th>
                        <th>Status</th>
                        <th>Posted On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notices as $notice)
                        <tr>
                            <td>{{ $notice->title }}</td>
                            <td><span class="badge bg-info">{{ $notice->target }}</span></td>
                            <td>
                                @if($notice->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $notice->created_at->format('d M Y') }}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('master.notices.edit', $notice->id) }}"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('master.notices.destroy', $notice->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $notices->links() }}
    </div>
</div>
@endsection
