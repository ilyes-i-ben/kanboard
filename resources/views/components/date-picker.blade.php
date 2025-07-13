@props(['id' => null, 'name' => null, 'value' => null, 'type' => null])

@if($type === 'range')
<div
    id="date-range-picker"
    datepicker-format="yyyy-mm-dd"
    date-rangepicker class="flex items-center"
    datepicker-buttons
>
    <input
        id="datepicker-range-start"
        name="start"
        type="text"
        class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm placeholder-gray-400 dark:placeholder-gray-500"
        placeholder="Select date start"
    />
    <span class="mx-4 text-gray-500">to</span>
    <input
        id="datepicker-range-end"
        name="end"
        type="text"
        class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm placeholder-gray-400 dark:placeholder-gray-500"
        placeholder="Select date end"
    />
</div>
@else
<input
    datepicker
    datepicker-format="yyyy-mm-dd"
    datepicker-buttons
    datepicker-autoselect-today
    type="text"
    @if($id) id="{{ $id }}" @endif
    @if($name) name="{{ $name }}" @endif
    @if($value) value="{{ $value }}" @endif
    class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white/80 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:outline-none px-3 py-2 text-sm placeholder-gray-400 dark:placeholder-gray-500"
    placeholder="Select date..."
/>
@endif
