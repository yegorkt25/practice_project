<x-app-layout>
    <x-slot name="header">
        <h2 class="inline font-semibold text-xl text-gray-800 leading-tight mr-2">
            {{ __('Profile') }}
        </h2>

        <a href="{{route('profile.edit')}}" class="inline text-xl text-gray-800 leading-tight">
            Edit
        </a>

    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-4">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>
                    </header>

                    <div class="mt-6 space-y-6">
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
    </div>

{{--    {{$user}} <br>--}}

</x-app-layout>
