@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-blue-400 focus:border-indigo-500 rounded-md shadow-sm pl-2 py-2']) }}>
