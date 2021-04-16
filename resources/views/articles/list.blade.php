<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
        @if(session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="m-2 float-right">
                    <a class="btn btn-primary" href="{{ route('addform') }}">Add New</a>
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($lists) === 0)
                        <tr><td colspan="5">No records found</td></tr>
                        @endif
                        @foreach ($lists as $index => $list)
                            <tr>
                                <th scope="row">{{ $index+1 }}</th>
                                <td>{{ $list->title }}</td>
                                <td>{{ $list->description }}</td>
                                <td>{{ $list->status ? 'Approved' : 'Pending' }}</td>
                                <td>
                                    <a href="/articles/view/{{ $list->id }}">View</a>
                                    @if ($list->status === 0 || Auth::user()->role === 1)
                                        <a href="/articles/add/{{ $list->id }}">Edit</a>
                                    @endif
                                    <a href="/articles/delete/{{ $list->id }}">Delete</a>
                                    @if (Auth::user()->role === 1 && $list->status === 0)
                                        <a href="/articles/approve/{{ $list->id }}">Approve</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-2">
                    {{ $lists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
