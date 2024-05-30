<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    {{$user}} <br>
    <a href="{{route('profile.edit')}}" class="hover:opacity-80">Edit</a>
</x-app-layout>
