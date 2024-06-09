<x-app-layout>
        <h2 class="text-center m-4 font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit post') }}
        </h2>
    {{--    --}}
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg m-auto">
        <form method="POST" action="{{ route('post.update', $post) }}">
            @csrf
            @method('PUT')
            <!-- Title of the post -->
            <div>
                <x-input-label for="title" :value="__('Post title')" />
                <x-text-input id="title" class="block mt-1 w-full" name="title" :value="old('title')" value="{{$post['title']}}" required autofocus/>
            </div>

            <!-- Post text -->
            <div class="mt-4">
                <x-input-label for="text" :value="__('Text')" />

                <x-text-area value="{{$post['text']}}" id="text" name="text"/>
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-primary-button class="ms-3">
                    {{ __('Edit') }}
                </x-primary-button>
            </div>
        </form>
    </div>



</x-app-layout>
