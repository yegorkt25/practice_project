@props(['disabled' => false, 'value' => ''])

<textarea required {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full h-40']) !!}>{{$value}}</textarea>

