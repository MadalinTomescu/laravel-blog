@extends('layouts.dashboard.base')
@section('pageTitle', 'Draft')
@section('content')

{{ Breadcrumbs::render('dashboard.posts.draft') }}

<div class="container-fluid mb-3">

    <div class="d-flex justify-content-between mb-3">
        <h1 class="page-heading">Posts</h1>
        <div>
            <a href="{{ route('dashboard.posts.create') }}" class="btn btn-sm btn-primary">New post</a>
        </div>
    </div>

    <a href="{{ route('dashboard.posts.index') }}" class="fs-14">
        Published ({{{ $publishedCount }}})
    </a>
    <a href="{{ route('dashboard.posts.draft') }}" class="fs-14 text-muted">
        Draft ({{{ $draftedCount }}})
    </a>
    <a href="{{ route('dashboard.posts.trash') }}" class="fs-14">
        Trash ({{ $trashCount }})
    </a>

    <div class="my-2 px-2 py-1 bg-white rounded box-shadow">
        <table class="table table-borderless fs-14 mb-0">

            <thead>
                <tr class="thead-row">
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Categories</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            @if (count($posts))
            <tbody>
                @foreach ($posts as $post)
                <tr scope="row">

                  <td>
                    <a href="{{ route('dashboard.posts.edit', $post->id) }}" class="font-weight-bold">
                        {{ $post->title }}
                    </a>
                </td>

                <td>
                    <a href="{{ route('users.show', $post->user->id) }}">
                        {{ $post->user->name }}
                    </a>
                </td>

                <td>
                    @foreach ($post->categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                    @if (!$loop->last), @endif
                    @endforeach
                </td>

                <td>
                    @forelse ($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}">
                        {{ $tag->name }}
                    </a>
                    @if (!$loop->last), @endif
                    @empty
                    -
                    @endforelse
                </td>

                <td>
                    @if ($post->comments()->exists())
                    <a href="{{ route('posts.show', $post->id)}}#comments">
                        {{ $post->comments->count() }}
                    </a>
                    @else
                    0
                    @endif
                </td>

                <td>
                    <abbr title="{{ $post->created_at }}">
                        {{ $post->created_at->format('Y/m/d') }}
                    </abbr>
                </td>

                <td>
                    {{-- Edit --}}
                    <a href="{{ route('dashboard.posts.edit', $post->id) }}" class="btn btn-link btn-sm c-666 p-0" data-toggle="tooltip" data-placement="top" title="Edit">
                        <span class="oi oi-pencil"></span>
                    </a>

                    {{-- Trash --}}
                    <form action="{{ route('dashboard.posts.destroy', $post->id) }}" method="POST" class="display-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-sm c-666 p-0" data-toggle="tooltip" data-placement="top" title="Delete">
                            <span class="oi oi-trash"></span>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@else
</table>
<p class="text-center my-3">No posts</p>
@endif

{{ $posts->links() }}

</div>
@endsection
