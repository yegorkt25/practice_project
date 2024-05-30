<x-app-layout>
    <p>User: {{\App\Models\User::query()->where('id', $post['user_id'])->get()[0]['email']}}</p>
    <h2 class="m-auto font-semibold text-xl text-gray-800 leading-tight">{{$post['title']}}</h2>
    <p class="">{{$post['text']}}</p>
    <p>{{$post['created_at']}}</p>

    @if($post['user_id'] == auth()->id())
        <div class="text-right">
            <a href="{{route('post.edit', $post)}}" class="hover:opacity-80">Edit</a>
            <form action="{{route('post.destroy', $post)}}" method="post" class="inline">
                @csrf
                @method('DELETE')
                <x-primary-button class="ms-3">
                    {{ __('Delete') }}
                </x-primary-button>
            </form>
        </div>
    @endif

</x-app-layout>
