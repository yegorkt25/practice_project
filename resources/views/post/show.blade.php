<x-app-layout>

    <div class="w-2/4 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 p-12">
        <p class="mb-6">{{\App\Models\User::query()->where('id', $post['user_id'])->get()[0]['email']}}</p>
        <h2 class="mb-4 font-semibold text-xl text-gray-800 leading-tight">{{$post['title']}}</h2>
        <p class="mb-6">{{$post['text']}}</p>

        <div class="text-right">
            <span class="float-left">
                {{$post['created_at']}}
            </span>

            @if($post['user_id'] == auth()->id())
                <div class="inline">
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

        </div>


    </div>



</x-app-layout>