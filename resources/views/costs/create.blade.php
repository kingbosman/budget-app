<x-layout>
    <x-slot:title>Add record</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline text-gray-300">
                Create new record  for {{ $budget->name }}
            </h1>
            <x-forms.form method="post" button="Create">
                <x-forms.input name="description" placeholder="Rent" value="{{ old('description') }}" />
                <x-forms.input name="amount" placeholder="123.50" value="{{ old('amount') }}" />
                <x-forms.input name="category" placeholder="Utility" value="{{ old('category') }}" />
            </x-forms.form>
        </div>
    </main>
</x-layout>
