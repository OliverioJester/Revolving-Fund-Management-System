@extends('main')

@section('title', 'List')

@section('content')
    <h1 class="my-5 font-bold">
        LIST
    </h1>
    <br>

    <h1>Expenses Categories</h1>
    <x-modal title="Add expense categories">
        <x-slot name="trigger">
            <x-Button>Add</x-Button>
        </x-slot>

        <x-slot name="content">
            <form action="{{route('list.store')}}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="expenses">Expenses Name</label>
                    <input type="text" id="expenses" name="expenses" class="border rounded p-2 w-full">
                </div>
                <div class="space-y-2">
                    <label for="description">Descriptions</label>
                    <input type="text" id="description" name="description" class="border rounded p-2 w-full">
                </div>
                <div class="flex justify-end mt-4 gap-3">
                    <x-Button type="submit">Save</x-Button>
                    <x-Button @click="open = false" variant="danger">Close</x-Button>
                </div>
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>            
        </x-slot>
    </x-modal>

    {{-- expenses --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 uppercase text-gray-700">
                <tr>
                    <th class="px-6 py-3 border">EXPENSE No.</th>
                    <th class="px-6 py-3 border">EXPENSE CATEGORIES</th>
                    <th class="px-6 py-3 border">Descriptions</th>
                    <th class="px-6 py-3 border">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($expenses as $expense)
                <tr>
                    <td class="px-6 py-4 border">{{ $expense->id }}</td>
                    <td class="px-6 py-4 border">{{ $expense->expenses }}</td>
                    <td class="px-6 py-4 border">{{ $expense->description }}</td>
                    <td class="px-6 py-4 border">
                        <span class="flex gap-2 ">
                            <x-modal title="Edit expense">
                                <x-slot name="trigger">
                                    <x-Button variant="secondary">Edit</x-Button>
                                </x-slot>

                                <x-slot name="content">
                                    <form action="{{ route('list.update', $expense->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="space-y-2">
                                            <label for="expenses">Expenses name</label>
                                            <input 
                                                type="text" 
                                                id="expenses" 
                                                name="expenses" 
                                                value="{{ old('expenses', $expense->expenses)}}" 
                                                class="border rounded p-2 w-full"
                                            >
                                        </div> 
                                        <div class="space-y-2">
                                            <label for="expenses">Category name</label>
                                            <input 
                                                type="text" 
                                                id="description" 
                                                name="description" 
                                                value="{{ old('description', $expense->description)}}" 
                                                class="border rounded p-2 w-full"
                                            >
                                        </div> 
                                        <div class="flex justify-end mt-4 gap-3">
                                            <x-Button @click="window.location.reload()"  variant="secondary">Reset</x-Button>
                                            <x-Button type="submit" variant="primary">Update</x-Button>
                                            <x-Button @click="open = false" variant="danger">Close</x-Button>
                                        </div> 
                                        
                                        @if ($errors->any())
                                            <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </form>
                                </x-slot>
                            </x-modal>

                            <form action="{{ route('list.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <x-Button type="submit" variant="danger">Delete</x-Button>
                            </form>
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <!-- Pagination -->
    </div>
    <div class="mt-3">
        {{ $expenses->appends(['search' => $search])->links() }}
    </div>
    
    <br>
    <h1>Non-expenses Categories</h1>
    <x-modal title="Add non-expense categories">
        <x-slot name="trigger">
            <x-Button>Add</x-Button>
        </x-slot>

        <x-slot name="content">
            <form action="{{route('list.nonexpenses.store')}}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="nonexpenses">Non-expenses Name</label>
                    <input type="text" id="nonexpenses" name="nonexpenses" class="border rounded p-2 w-full">
                </div>
                <div class="space-y-2">
                    <label for="description">Descriptions</label>
                    <input type="text" id="description" name="description" class="border rounded p-2 w-full">
                </div>
                <div class="flex justify-end mt-4 gap-3">
                    <x-Button type="submit">Save</x-Button>
                    <x-Button @click="open = false" variant="danger">Close</x-Button>
                </div>
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>            
        </x-slot>
    </x-modal>
    {{-- non expenses --}}
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 mt-10">
        <thead class="bg-gray-100 uppercase text-gray-700">
            <tr>
                <th class="px-6 py-3 border">Non-category no.</th>
                <th class="px-6 py-3 border">NON-EXPENSE ACCOUNTS</th>
                <th class="px-6 py-3 border">Descriptions</th>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($nonexpenses as $nonexpense)
             <tr>
                <td class="px-6 py-4 border">{{$nonexpense->id}}</td>
                <td class="px-6 py-4 border">{{$nonexpense->nonexpenses}}</td>
                <td class="px-6 py-4 border">{{$nonexpense->description}}</td>
                <td class="px-6 py-4 border">
                    <span class="flex gap-2 ">
                        <x-modal title="Edit expense">
                            <x-slot name="trigger">
                                <x-Button variant="secondary">Edit</x-Button>
                            </x-slot>

                            <x-slot name="content">
                                <form action="{{ route('list.nonexpenses.update', $nonexpense->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="space-y-2">
                                        <label for="expenses">Expenses name</label>
                                        <input 
                                            type="text" 
                                            id="nonexpenses" 
                                            name="nonexpenses" 
                                            value="{{ old('expenses', $nonexpense->nonexpenses)}}" 
                                            class="border rounded p-2 w-full"
                                        >
                                    </div> 
                                    <div class="space-y-2">
                                        <label for="expenses">Category name</label>
                                        <input 
                                            type="text" 
                                            id="description" 
                                            name="description" 
                                            value="{{ old('description', $nonexpense->description)}}" 
                                            class="border rounded p-2 w-full"
                                        >
                                    </div> 
                                    <div class="flex justify-end mt-4 gap-3">
                                        <x-Button @click="window.location.reload()"  variant="secondary">Reset</x-Button>
                                        <x-Button type="submit" variant="primary">Update</x-Button>
                                        <x-Button @click="open = false" variant="danger">Close</x-Button>
                                    </div> 
                                    
                                    @if ($errors->any())
                                        <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            </x-slot>
                        </x-modal>

                        <form action="{{ route('list.nonexpenses.destroy', $nonexpense->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <x-Button type="submit" variant="danger">Delete</x-Button>
                        </form>
                    </span>
                </td>
            </tr>               
            @endforeach
        </tbody>
    </table>
</div>
    <!-- Pagination -->
    <div class="mt-3">
        {{ $nonexpenses->appends(['search' => $search])->links() }}
    </div>
@endsection     