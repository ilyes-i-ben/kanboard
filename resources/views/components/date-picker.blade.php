@props(['id' => null, 'name' => null, 'value' => null])

<input
    datepicker
    type="text"
    @if($id) id="{{ $id }}" @endif
    @if($name) name="{{ $name }}" @endif
    @if($value) value="{{ $value }}" @endif
    class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm placeholder-gray-400 dark:placeholder-gray-500"
    placeholder="Select date..."
/>
