<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <h3>Add New Article</h3>
                <form method="POST" action="{{ route('addarticle') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id ?? 0}}" />
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="title" class="form-control" id="title" placeholder="Enter Title" name="title" value="{{$data->title ?? ''}}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea rows="5" class="form-control" id="description" placeholder="Enter the content of article" name="description" required>{{ $data->description ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>