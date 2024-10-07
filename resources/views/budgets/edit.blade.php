<x-layout>
    <x-slot:title>Add Budget</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline text-gray-300">
                Update {{ $budget->name }}
            </h1>
            <div class="flex flex-1">
                <div class="flex flex-1 justify-end">
                    <form method="POST" action="{{ route('budgets.delete', $budget) }}">
                        @csrf
                        @method('delete')
                        <button type="submit" onclick="return confirm('Delete {{ $budget->name }}')" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <x-forms.form method="patch" button="Update">
                <x-forms.input name="name" value="{{ $budget->name }}" />
            </x-forms.form>

    </main>
</x-layout>
