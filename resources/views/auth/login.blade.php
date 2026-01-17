
    <div class="bg-gray-800 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white shadow-xl rounded-xl p-8">

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Revolving Fund
        </h1>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition text-white py-2 rounded-lg font-semibold">
                Login
            </button>
        </form>

    </div>
    </div>

