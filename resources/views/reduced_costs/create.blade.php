<x-layout>
    <x-slot:title>Reduce Cost</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline text-gray-300">
                Reduce {{ $cost->description }}
            </h1>
            <x-forms.form method="post" button="Reduce">
                <x-forms.input name="amount" placeholder="12.99" value="{{ old('amount') }}" />
            </x-forms.form>
        </div>
    </main>
</x-layout>
