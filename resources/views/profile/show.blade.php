<x-app-layout>
    <x-slot name="header">
        <h2 class="inline font-semibold text-xl text-gray-800 leading-tight mr-2">
            {{ __('Profile') }}
        </h2>

        @if($user->id == auth()->id())
            <a href="{{route('profile.edit')}}" class="inline text-xl text-gray-800 leading-tight">
                Edit
            </a>
        @endif

    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-4">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>
        </header>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <section>


                    <div class="space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <p class="mt-1 block w-full">{{$user->name}}</p>
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Registered at')" />
                            <p class="mt-1 block w-full">{{$user->created_at}}</p>

                        </div>
                    </div>

                </section>

            </div>
        </div>

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Posts') }}
        </h2>

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

    </div>

    {{--    {{$user}} <br>--}}

</x-app-layout>
