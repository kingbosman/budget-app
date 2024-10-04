<x-layout>
    <x-slot:title>Add Budget</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline">
                Create new budget
            </h1>
            <a class=" text-blue-700" href="{{ route('budgets.index') }}">Go back</a>
            <x-forms.form method="post" button="Create">
                <x-forms.input name="name" placeholder="Annie & John" />
            </x-forms.form>
        </div>
    </main>
</x-layout>
