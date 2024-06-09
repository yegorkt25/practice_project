<x-app-layout>
{{--    {{$users}}--}}
    @foreach($users as $user)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a href="{{route('profile.show', $user)}}">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="mb-3">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{$user->name}} </h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
</x-app-layout>

