<nav class="bg-gray-800 text-white fixed top-0 left-0 w-full z-50" x-data="{ open: false }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <div class="flex shrink-0">
        <a href="/consolidates" class="text-xl font-bold">Revolving Fund</a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-6">
        <a href="{{ url('/consolidates') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Consolidated</a>
        <a href="{{ url('/reported') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Reported</a>
        <a href="{{ url('/unreported') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Unreported</a>
        <a href="{{ url('/list') }}" class="hover:bg-gray-700 px-3 py-2 rounded">List</a>
        {{-- <a href="{{ url('/chart-of-accounts') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Chart of Account</a> --}}
        <a href="{{ url('/employees') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Employees</a>
        <a href="{{ url('/suppliers') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Suppliers</a>
        <a href="{{ url('/area-of-customers') }}" class="hover:bg-gray-700 px-3 py-2 rounded">Area</a>

        <!-- Profile Dropdown (hover only, no Alpine toggle) -->
<!-- Profile Dropdown -->
<div class="relative group">
    <button class="flex items-center space-x-2 focus:outline-none">
        <span class="hidden md:block text-sm">{{ Auth::user()->name }}</span>

        <!-- Arrow SVG -->
        <svg class="w-4 h-4 text-white transition-transform duration-200 transform -rotate-180 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div class="absolute right-0 top-5  w-40 bg-white rounded-md shadow-lg
                opacity-0 invisible group-hover:opacity-100 group-hover:visible
                transform group-hover:translate-y-1 transition-all duration-200 z-50">
        
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full rounded-md text-left px-4 py-2 hover:bg-gray-300 hover:text-black text-gray-800 ">
                Logout
            </button>
        </form>
    </div>
</div>

      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden flex items-center">
        <button @click="open = !open" type="button" class="focus:outline-none">
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" x-transition class="md:hidden bg-gray-700">
    <a href="{{ url('/consolidates') }}" class="block px-4 py-2 hover:bg-gray-600">Consolidated</a>
    <a href="{{ url('/reported') }}" class="block px-4 py-2 hover:bg-gray-600">Reported</a>
    <a href="{{ url('/unreported') }}" class="block px-4 py-2 hover:bg-gray-600">Unreported</a>
    <a href="{{ url('/list') }}" class="block px-4 py-2 hover:bg-gray-600">List</a>
    {{-- <a href="{{ url('/chart-of-accounts') }}" class="block px-4 py-2 hover:bg-gray-600">Chart of account</a> --}}
    <a href="{{ url('/employees') }}" class="block px-4 py-2 hover:bg-gray-600">Employees</a>
    <a href="{{ url('/suppliers') }}" class="block px-4 py-2 hover:bg-gray-600">Suppliers</a>
    <hr class="border-gray-600">
    <a href="#" class="block px-4 py-2 hover:bg-gray-600">Logout</a>
  </div>
</nav>
