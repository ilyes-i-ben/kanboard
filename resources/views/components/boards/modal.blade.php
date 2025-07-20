@props([
    'task' => null,
    'mode' => 'create',
    'id' => '0',
])

@php
    $name = $mode === 'edit' ? 'edit-task-modal' : 'create-task-modal';
    $action = $mode === 'edit' ? route('tasks.update', $task['id'] ?? 1) : route('tasks.store');
    $method = $mode === 'edit' ? 'PUT' : 'POST';
@endphp

<x-modal id="{{ $id }}" name="{{ $name }}" size="3xl">
    <form method="POST" action="{{ $action }}" class="p-4">
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif
        <div
            class="space-y-4"
            x-data="{
                priority: '{{ old('priority') ?? ($task['priority'] ?? 'medium') }}',
                get priorityTranslated() {
                    const translations = {
                        high: @js(__('High')),
                        medium: @js(__('Medium')),
                        low: @js(__('Low'))
                    };
                    return translations[this.priority] || this.priority;
                }
            }"
        >
            <x-input-label for="title" :errorName="'title'" :value="__('Title')"/>
            <x-text-input
                id="title"
                name="title"
                type="text"
                class="mt-1 block w-full"
                placeholder="Example title for task"
                value="{{ old('title') ?? ($task['title'] ?? '') }}"
                required
            />
            <x-input-label for="priority" :errorName="'priority'" :value="__('Priority')" />
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button type="button" class="inline-flex w-full justify-between items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <span x-text="priorityTranslated"></span>
                        <x-heroicon-m-chevron-down class="w-6 h-6" />
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link href="#" @click.prevent="priority = 'high'; $dispatch('close')">
                        {{ __('High') }}
                    </x-dropdown-link>
                    <x-dropdown-link href="#" @click.prevent="priority = 'medium'; $dispatch('close')">
                        {{ __('Medium') }}
                    </x-dropdown-link>
                    <x-dropdown-link href="#" @click.prevent="priority = 'low'; $dispatch('close')">
                        {{ __('Low') }}
                    </x-dropdown-link>
                    <input type="hidden" name="priority" x-bind:value="priority">
                </x-slot>
            </x-dropdown>
            <x-input-label for="description" :errorName="'description'" :value="__('Description')" />
            <x-textarea
                id="description"
                name="description"
                class="tinyMce"
            >{{ old('description') ?? ($task['description'] ?? '') }}</x-textarea>
        </div>
        <div class="mt-4 flex justify-end gap-4">
            <x-secondary-button @click="$dispatch('close-modal', '{{ $name }}')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-primary-button class="ml-2">
                {{ $mode === 'edit' ? __('Update') : __('Create') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
