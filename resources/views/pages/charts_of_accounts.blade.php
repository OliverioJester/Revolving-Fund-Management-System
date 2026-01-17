@extends('main')

@section('title', 'Charts of accounts')

@section('content')

    <div>
        <h1 class="font-bold">POWERTRAC INCORPORATED</h1>
        <p>2015-C APOLONIA ST BRGY MAPULANG LUPA DIST 2 VALENZUELA CITY</p>
        <p>TIN: 008-280-344-000</p>
    </div>

    <h1 class="my-5 font-bold">
        CHART OF ACCOUNTS LISTINGS
    </h1>

    <br>

    <x-modal title="Add chart of account">
        <x-slot name="trigger">
            <x-Button>Add</x-Button>
        </x-slot>

        <x-slot name="content">
            <form action="{{ route('chart-of-accounts.store') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="account_code">Account code</label>
                    <input 
                        type="number" 
                        id="account_code" 
                        name="account_code"
                        class="border rounded p-2 w-full"
                    >
                </div>
                <div class="space-y-2">
                    <label for="account_title">Account title</label>
                    <input 
                        type="text" 
                        id="account_title" 
                        name="account_title"
                        class="border rounded p-2 w-full"
                    >
                </div>
                <div class="space-y-2">
                    <label for="remarks">Remarks</label>
                    <input 
                        type="text" 
                        id="remarks" 
                        name="remarks"
                        class="border rounded p-2 w-full"
                    >
                </div>        
                <div class="flex justify-end mt-4 gap-3">
                    <x-Button type="submit">Save</x-Button>
                    <x-Button @click="open = false" variant="danger">Close</x-Button>
                </div>
            </form>
        </x-slot>
    </x-modal>
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100 uppercase text-gray-700">
            <tr>
                <th class="px-6 py-3 border">Accout no.</th>
                <th class="px-6 py-3 border">Account Code</th>
                <th class="px-6 py-3 border">Account title</th>
                <th class="px-6 py-3 border">Remarks</th>
                <th class="px-6 py-3 border">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($chartofaccounts as $chartofaccount)
            <tr>
                <td class="px-6 py-4 border">{{ $chartofaccount->id }}</td>
                <td class="px-6 py-4 border">{{ $chartofaccount->account_code }}</td>
                <td class="px-6 py-4 border">{{ $chartofaccount->account_title }}</td>
                <td class="px-6 py-4 border">{{ $chartofaccount->remarks }}</td>
                <td class="px-6 py-4 border">
                    <span class="flex gap-2">
                    <x-modal title="Edit Item">
                        <x-slot name="trigger">
                            <x-Button variant="secondary">Edit</x-Button>
                        </x-slot>

                        <x-slot name="content">
                            <form action="{{ route('chart-of-accounts.update', $chartofaccount->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-2">
                                    <label for="account_code">Account code</label>
                                    <input 
                                           type="text"
                                           id="account_code"
                                           name="account_code"
                                           value="{{ old('account_code', $chartofaccount->account_code) }}"
                                           class="border rounded p-2 w-full"
                                    >
                                </div>
                                <div class="space-y-2">
                                    <label for="account_title">Account title</label>
                                    <input 
                                           type="text"
                                           id="account_title"
                                           name="account_title"
                                           value="{{ old('account_title', $chartofaccount->account_title) }}"
                                           class="border rounded p-2 w-full"
                                    >
                                </div>
                                <div class="space-y-2">
                                    <label for="remarks">Account title</label>
                                    <input 
                                           type="text"
                                           id="remarks"
                                           name="remarks"
                                           value="{{ old('remarks', $chartofaccount->remarks) }}"
                                           class="border rounded p-2 w-full"
                                    >
                                </div>
                
                                <div class="flex justify-end mt-4 gap-3">
                                    <x-Button @click="window.location.reload()" variant="secondary">Reset</x-Button>
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
                    <form action="{{ route('chart-of-accounts.destroy', $chartofaccount->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
@endsection     