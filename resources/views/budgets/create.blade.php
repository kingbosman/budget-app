<x-layout>
    <x-slot:title>Add Budget</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline text-gray-300">
                Create new budget
            </h1>
            <x-forms.form method="post" button="Create">
                <x-forms.input name="name" placeholder="Annie & John" />
            </x-forms.form>
        </div>
    </main>
</x-layout>
