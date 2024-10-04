<x-layout>
    <x-slot:title>Login</x-slot:title>
    <main>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline">
                Register
            </h1>
            <x-forms.form method="post" button="Register">
                <x-forms.input name="name" placeholder="John" value="{{ old('name') }}" />
                <x-forms.input name="email" placeholder="John@email.com" value="{{ old('name') }}" />
                <x-forms.input name="password" input="password" />
                <x-forms.input name="password_confirmation" input="password" />
            </x-forms.form>
        </div>
    </main>
</x-layout>
