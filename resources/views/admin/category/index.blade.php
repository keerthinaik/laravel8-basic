<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Categories

            <b style="float:right" class="badge rounded-pill bg-danger"> Total Category {{ count($categories) }} </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                @if(session('success'))
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            All Category
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Sl No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Created by</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <th scope="row">{{ $categories->firstItem() + $loop->index }}</th>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->user->name }}</td>
                                        <td>
                                            @if($category->created_at == NULL)
                                                <span class="text-danger">No Data Found</span>
                                            @else
                                                {{ $category->created_at }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('category/edit/'.$category->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ url('category/softdelete/'.$category->id) }}"
                                               class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $categories->links() }}
                        </div>
                    </div>
                    <br/>
                    <div class="card">
                        <div class="card-header">
                            Trash Category
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Sl No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Created by</th>
                                    <th scope="col">Deleted At</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trashCategories as $category)
                                    <tr>
                                        <th scope="row">{{ $categories->firstItem() + $loop->index }}</th>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->user->name }}</td>
                                        <td>
                                            @if($category->deleted_at == NULL)
                                                <span class="text-danger">No Data Found</span>
                                            @else
                                                {{ $category->deleted_at->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('category/restore/'.$category->id) }}"
                                               class="btn btn-warning">Restore</a>
                                            <a href="{{ url('category/permanent_delete/'.$category->id) }}"
                                               class="btn btn-danger">Permanent Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $trashCategories->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Add Category
                        </div>
                        <div class="card-body">
                            <form action="{{ route('add.category') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">Category Name</label>
                                    <input type="text" name="name" class="form-control" id="categoryName">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
