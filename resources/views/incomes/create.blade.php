<x-layout>
    <x-slot:title>Add Income</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline text-gray-300">
                Create new income for {{ $budget->name }}
            </h1>
            <x-budgets.tabs :$budget />
            <x-forms.form method="post" button="Create">
                <x-forms.input name="name" placeholder="Annie & John" value="{{ old('name') }}" />
                <x-forms.input name="amount" placeholder="1203.56" value="{{ old('name') }}" />
            </x-forms.form>
        </div>
    </main>
</x-layout>
