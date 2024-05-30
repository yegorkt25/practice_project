<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
    </x-slot>

    @foreach($posts as $post)
        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a href="{{route('post.show', $post)}}">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-semibold text-xl text-gray-800 leading-tight">{{$post['title']}}</h3> <br>
                            <p>{{$post['text']}}</p> <br>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach


</x-app-layout>
