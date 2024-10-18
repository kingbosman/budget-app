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
                        <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $budget->name }}')" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <x-forms.form method="patch" button="Update">
                <x-forms.input name="name" value="{{ $budget->name }}" />
            </x-forms.form>

        </div>
        <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="mb-5 text-3xl font-bold underline text-gray-300">Sharing</h1>
            <x-forms.form method="post" button="Share" action="{{ route('budgets.share', $budget) }}">
                <x-forms.input name="email" placeholder="John@planet.nl" value="{{ old('email') }}" />
            </x-forms.form>

            @if(true)
                <h3 class="mb-5 text-xl font-bold underline text-gray-300">Shared with</h3>

                @error('user_id')
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-red-500" role="alert">
                    <span class="font-medium">{{ $message }}</span>
                </div>
                @enderror
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-10">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($budget->users as $user)
                            @if($user->id !== Auth::id())
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ ucfirst($user->name) }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ strtolower($user->email) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('budgets.share.delete', $budget) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <input name="user_id" type="hidden" value="{{ $user->id }}">
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete {{ $user->name }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </main>
</x-layout>
