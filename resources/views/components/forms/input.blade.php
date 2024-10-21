@props([
    'name' => false,
    'input' => 'text',
    'label' => false,
])
<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
    <div class="sm:col-span-4">
        <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-300">{{ ($label) ? $label : ucfirst($name) }}</label>
        <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input {{$attributes([
                    'type' => $input,
                    'name' => $name,
                    'id' => $name,
                    'class' => "block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-300 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                ])}}>
            </div>
            @error($name)
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
