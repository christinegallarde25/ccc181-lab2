<x-guest-layout>
    <div class="text-center">
        <h1 class="mb-2 text-xl font-semibold text-green-900">Registration successful</h1>
        <p class="mb-6 text-sm text-stone-600">Your account has been created. Please log in to continue.</p>
        <a class="inline-flex items-center rounded-md bg-green-900 px-4 py-2 text-sm font-medium text-white hover:bg-green-800" href="{{ route('login') }}">
            Go to log in
        </a>
    </div>
</x-guest-layout>
