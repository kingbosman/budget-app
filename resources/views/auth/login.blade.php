<x-layout>
    <x-slot:title>Login</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline">
                Login
            </h1>
            <x-forms.form method="post" button="Login">
                <x-forms.input name="email" placeholder="john@email.com" value="{{ old('email') }}" />
                <x-forms.input name="password" input="password" />
            </x-forms.form>
        </div>
    </main>


</x-layout>
