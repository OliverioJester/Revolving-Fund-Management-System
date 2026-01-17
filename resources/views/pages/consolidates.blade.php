@extends('main')

@section('title', 'Consolidate ')

@section('content')
    <div class="mb-3">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex">
            {{-- Add period, transmittal, and reports --}}
            <x-modal title="Add Period & Transmittal">
                <x-slot name="trigger">
                    @if ($period_and_transmittals == null)
                    <x-Button  >
                        Add Period & Transmittal
                    </x-Button>                               
                    @endif
                

                </x-slot>
                <x-slot name="content">
                    <form action="{{ route('consolidates.period_and_transmittal.store') }}" method="POST">
                        @csrf
                        <h1 class="font-medium text-gray-700">For The Period of</h1>
                        <div class="flex gap-5 items-center mb-4">
                            <x-input name="first_period" type="date" class="bg-gray-50" />
                            <span class=" font-bold">-</span>
                            <x-input name="second_period" type="date" class="bg-gray-50" />
                        </div>
                        <x-input label="Transmittal Slip" name='transmittal' type='text' class="bg-gray-50 mt-4" />
                        <x-input label="Revolving service fund report" name='revolving_report' type='text' class="bg-gray-50" />
                        <div class="flex justify-end mt-4 gap-3">
                            <x-Button type="submit">Save</x-Button>
                            <x-Button @click="open = false" variant="danger">Close</x-Button>
                        </div> 
                    </form>    
                </x-slot>
            </x-modal>

            {{-- Update period, transmittal, and reports --}}
            @foreach ($period_and_transmittals as $period_and_transmittal)
                    <x-modal title="Edit Period & Transmittal">
                        <x-slot name="trigger">
                            <x-Button variant='secondary'>Edit Period & Transmittal</x-Button>
                        </x-slot>
                        <x-slot name="content">
                            <form action="{{ route('consolidates.period_and_transmittal.update', $period_and_transmittal->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h1 class="font-medium text-gray-700">For The Period of</h1>
                                <div class="flex gap-5 items-center mb-4">
                                    <x-input 
                                        name="first_period" 
                                        type="date" 
                                        class="bg-gray-50" 
                                        value="{{ old('first_period', $period_and_transmittal->first_period->format('Y-m-d')) }}"
                                    />
                                    <span class=" font-bold">-</span>
                                    <x-input 
                                        name="second_period" 
                                        type="date" 
                                        class="bg-gray-50" 
                                        value="{{ old('second_period', $period_and_transmittal->second_period->format('Y-m-d')) }}"
                                    />
                                    </div>
                                    <x-input 
                                        label="Transmittal Slip" 
                                        name='transmittal' 
                                        type='text' 
                                        class="bg-gray-50 mt-4"
                                        value="{{ old('transmittal', $period_and_transmittal->transmittal) }}"
                                    />
                                    <x-input 
                                        label="Revolving service fund report" 
                                        name='revolving_report' 
                                        type='text' 
                                        class="bg-gray-50" 
                                        value="{{ old('revolving_report', $period_and_transmittal->revolving_report) }}"
                                    />
                                    <div class="flex justify-end mt-4 gap-3">
                                        <x-Button type="submit">Save</x-Button>
                                        <x-Button @click="open = false" variant="danger">Close</x-Button>
                                    </div> 
                            </form>   
                            
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        </x-slot>
                    </x-modal>                
            @endforeach
        </div>

        <table id="transmitalSlip">
                <thead>
                    <tr>
                        <th class="font-bold text-left">
                                POWERTRAC INC-SERVICE
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($period_and_transmittals as $period_and_transmittal)
                    <tr>
                        <td class="font-bold">
                            For The Period of
                            {{ $period_and_transmittal->first_period->format('F-d-Y')}} - {{ $period_and_transmittal->second_period->format('F-d-Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold">
                                TRANSMITTAL SLIP
                            #{{  $period_and_transmittal->transmittal ?? '-'}}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold">
                            REVOLVING SERVICE FUND REPORT
                            #{{ $period_and_transmittal->revolving_report ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="font-bold">CONSOLIDATE</td>
                    </tr>
                </tfoot>
        </table>

        <div class="flex justify-between">
            {{-- Add Consolidates --}}
            <x-modal title="Add consolidates">
                <x-slot name="trigger">
                    <x-Button>Add consolidates</x-Button>
                </x-slot>

                <x-slot name="content">
                    <form action="{{route('consolidates.store')}}" method="POST">
                        @csrf
                        <x-input label="Date" name="date_consolidate" type="date" class="bg-gray-50 mb-8" />
                        
                        <x-input label="PCV NO." name="pvc" type="number" class="bg-gray-50 mb-8" />
                        
                        <label for="employee_id" class="font-medium text-gray-700">PAYEE</label>
                        <select name="employee_id" id="employee_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                            <option value="">Select employee</option>
                            @foreach ($allEmployeeDatas as $allEmployeeData)
                                <option value="{{ $allEmployeeData->id }}">
                                    {{ $allEmployeeData->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        
                        <label for="areacustomer_id" class="font-medium text-gray-700">AREA & CUSTOMER</label>
                        <select name="areacustomer_id" id="areacustomer_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                            <option value="">Select Area</option>
                            @foreach ($allAreacustomers as $allAreacustomer)
                                <option value="{{ $allAreacustomer->id }}">
                                    {{ $allAreacustomer->area }}
                                </option>
                            @endforeach
                        </select>
                        
                        <label for="areacustomer_id" class="font-medium text-gray-700">Reported or Unreported</label>
                        <select label="Reported or Unreported" name="reported_and_unreported" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                            <option value="" hidden>Select Area</option>
                            <option value="Reported">REPORTED</option>
                            <option value="Unreported">UNREPORTED</option>
                        </select>

                        <label for="remarks" class="block font-medium text-gray-700">Remarks</label>
                        <textarea
                            name="remarks"
                            id="remarks"
                            rows="4"
                            class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8"
                        ></textarea>

                        <x-input label="Date of Receipt" name="date_receipt" type="date" class="bg-gray-50 mb-8" />
                        
                        <x-input label="Receipt / Invoice No." name="receipt_invoice" type="text" class="bg-gray-50 mb-8" />
                        
                        <label for="supplier_id" class="font-medium text-gray-700">SUPPLIER NAME or PROPRIETOR</label>
                        <select name="supplier_id" id="supplier_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                            <option value="">Select employee</option>
                            @foreach ($allSuppliers as $allSupplier)
                                <option value="{{ $allSupplier->id }}">
                                    {{ $allSupplier->name }}
                                </option>
                            @endforeach
                        </select>                            
                        
                        <x-input label="ADDRESS" name="address" type="text" class="bg-gray-50 mb-8" />
                        
                        <x-input label="T.I.N. #" name="tin" type="text" class="bg-gray-50 mb-8" />

                        <div x-data="{
                            expenses: '',
                            nonexpenses: ''
                        }">
                            <label for="expensescategory_id" class="font-medium text-gray-700">EXPENSES CATEGORIES</label>
                            <select 
                                name="expensescategory_id" 
                                id="expensescategory_id"
                                x-model="expenses"
                                :disabled="nonexpenses !== ''"
                                class="
                                        border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8
                                        disabled:bg-gray-100 disabled:text-gray-500 
                                        disabled:cursor-not-allowed disabled:border-gray-200
                                    "
                            >
                                <option value="">Select expenses category</option>
                                @foreach ($allExpensesCategories as $allExpensesCategory)
                                    <option value="{{ $allExpensesCategory->id }}">
                                        {{ $allExpensesCategory->expenses }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="nonexpensescategory_id" class="font-medium text-gray-700">NON-EXPENSES CATEGORIES</label>
                            <select 
                                name="nonexpensescategory_id" 
                                id="nonexpensescategory_id"
                                x-model="nonexpenses"
                                :disabled="expenses !== ''"
                                class="
                                        border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8
                                        disabled:bg-gray-100 disabled:text-gray-500 
                                        disabled:cursor-not-allowed disabled:border-gray-200
                                        "
                            >
                                <option value="">Select non-expenses category</option>
                                @foreach ($allNonexpensesCategories as $allNonexpensesCategory)
                                    <option value="{{ $allNonexpensesCategory->id }}">
                                        {{ $allNonexpensesCategory->nonexpenses }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <x-input label="Net Vat" name="net_vat" type="number" class="bg-gray-50 mb-8" />
                        
                        <x-input label="Input Vat" name="input_vat" type="number" class="bg-gray-50 mb-8" />

                        <x-input label="Non-Vat(Unreported all here)" name="non_vat" type="number" class="bg-gray-50 mb-8" />

                        <x-input label="ewt" name="ewt" type="number" class="bg-gray-50 " /> 

                        <div class="flex justify-end mt-4 gap-3">
                            <x-Button type="submit">Save</x-Button>
                            <x-Button @click="open = false" variant="danger">Close</x-Button>
                        </div> 
                    </form>           
                </x-slot>
            </x-modal>

            <x-Button onclick="downloadExcel()">Export to Excel</x-Button>

            <form action="{{ route('consolidates.bulk-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all?')">
                @csrf
                @method('DELETE')
                <x-Button type="submit" variant="danger">Delete all</x-Button>
            </form>            
            {{-- Delete All --}}

        </div>

        <div class="overflow-x-auto mt-1">
            <table class="min-w-full divide-y divide-gray-200" id="consolidatesTable">
                    <thead class="bg-gray-100 uppercase text-gray-700">
                        <tr>
                            <th class="px-6 py-3 border actions no-export">Actions</th>
                            <th class="px-16 py-3 border">DATE</th>
                            <th class="px-6 py-3 border">PCV NO.</th>
                            <th class="px-24 py-3 border">PAYEE</th>
                            <th class="px-6 py-3 border">AREA & CUSTOMER</th>
                            <th class="px-6 py-3 border">REPORTED/<br>UNREPORTED</th>
                            <th class="px-24 py-3 border">REMARKS</th>
                            <th class="px-6 py-3 border">Date of Receipt</th>
                            <th class="px-6 py-3 border">Receipt / Invoice No.</th>
                            <th class="px-6 py-3 border">SUPPLIER NAME or PROPRIETOR</th>
                            <th class="px-6 py-3 border">ADDRESS</th>
                            <th class="px-6 py-3 border">T.I.N. #</th>
                            <th class="px-6 py-3 border">TYPE</th>
                            <th class="px-6 py-3 border">EXPENSE CATEGORY</th>
                            <th class="px-6 py-3 border">GROSS AMT</th>
                            <th class="px-6 py-3 border">NET OF VAT</th>
                            <th class="px-6 py-3 border">INPUT VAT</th>
                            <th class="px-6 py-3 border">NON-VAT (Unreported All Here)</th>
                            <th class="px-6 py-3 border">EWT</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @php
                        $currentPvc = null;
                        $grossTotal = 0;
                        $netvatTotal = 0;
                        $inputvatTotal = 0;
                        $nonvatTotal = 0;


                    @endphp

                    @foreach ($consolidates as $consolidate)
                        @if ($currentPvc !== null && $currentPvc != $consolidate->pvc)
                            <!-- Output total row for previous PVC -->
                            <tr class="bg-gray-200 font-bold ">
                                <td class="no-export"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="1" class="border px-3 py-4 text-right">Type: {{ ($netvatTotal !== 0 && $inputvatTotal !== 0) ? 'VAT' : 'NV' }}</td>                                
                                <td colspan="1" class="border px-2 py-4 text-center">Total Gross Amt:<br/>{{ number_format($grossTotal, 2) }}</td>
                                <td class="border"></td> 
                                <td colspan="1" class="border px-2 py-4 text-center">Total net of vat:<br/>{{ number_format($netvatTotal, 2) }}</td>
                                <td colspan="1" class="border px-2 py-4 text-center">Total input vat:<br/>{{ number_format($inputvatTotal, 2) }}</td>
                                <td colspan="1" class="border px-2 py-4 text-center">Total Non Vat:<br/>{{ number_format($nonvatTotal, 2) }}</td>
                                <td class="border"></td> 
                            </tr>

                            @php
                                $grossTotal = 0; // reset total for new PVC
                                $netvatTotal = 0;
                                $inputvatTotal = 0;
                                $nonvatTotal = 0;
                            @endphp
                        @endif

                        <tr> 
                            {{-- edit and delete consolidates --}}
                            <td class="px-6 py-4 border actions no-export">
                                <span class="flex gap-2">
                                    <x-modal title="Edit consolidates">
                                        <x-slot name="trigger">
                                            <x-Button>Edit</x-Button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <form action="{{ route('consolidates.update', $consolidate->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <x-input label="Date" name="date_consolidate" type="date" value="{{ old('date_consolidate', $consolidate->date_consolidate->format('Y-m-d')) }}" class="bg-gray-50 mb-8" />
                                                
                                                <x-input label="PCV NO." name="pvc" type="number" value="{{ old('pvc', $consolidate->pvc) }}" class="bg-gray-50 mb-8" />
                                                
                                                <label for="employee_id" class="font-medium text-gray-700">PAYEE</label>
                                                <select name="employee_id" id="employee_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                                                    <option value="">Select employee</option>
                                                    @foreach ($allEmployeeDatas as $allEmployeeData)
                                                        <option 
                                                            value="{{ $allEmployeeData->id }}"
                                                            {{ old('employee_id', $consolidate->employee_id) == $allEmployeeData->id ? 'selected' : '' }}
                                                        >
                                                                {{ $allEmployeeData->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                
                                                
                                                <label for="areacustomer_id" class="font-medium text-gray-700">AREA & CUSTOMER</label>
                                                <select name="areacustomer_id" id="areacustomer_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                                                    <option value="">Select Area</option>
                                                    @foreach ($allAreacustomers as $allAreacustomer)
                                                        <option
                                                            value="{{ $allAreacustomer->id }}" 
                                                            {{ old('areacustomer_id', $consolidate->areacustomer_id) == $allAreacustomer->id ? 'selected' : '' }}
                                                        >
                                                                {{ $allAreacustomer->area }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                
                                                <label for="areacustomer_id" class="font-medium text-gray-700">Reported or Unreported</label>
                                                <select label="Reported or Unreported" name="reported_and_unreported" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                                                    <option value="" hidden>Select Area</option>
                                                    <option value="Reported"
                                                    {{ old('reported_and_unreported', $consolidate->reported_and_unreported) == 'Reported' ? 'selected' : '' }}>
                                                        REPORTED
                                                    </option>
                                                    <option value="Unreported" 
                                                    {{ old('reported_and_unreported', $consolidate->reported_and_unreported) == 'Unreported' ? 'selected' : '' }}>
                                                        UNREPORTED
                                                </option>
                                                </select>

                                                <label for="remarks" class="block font-medium text-gray-700">Remarks</label>
                                                <textarea
                                                    name="remarks"
                                                    id="remarks"
                                                    rows="4"
                                                    class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8"
                                                >
                                                    {{ old('remarks', $consolidate->remarks) }}
                                                </textarea>

                                                <x-input label="Date of Receipt" name="date_receipt" type="date" value="{{ old('date_receipt', $consolidate->date_receipt->format('Y-m-d')) }}" class="bg-gray-50 mb-8" />
                                                
                                                <x-input label="Receipt / Invoice No." name="receipt_invoice" type="text" value="{{ old('receipt_invoice', $consolidate->receipt_invoice) }}" class="bg-gray-50 mb-8" />
                                                
                                                <label for="supplier_id" class="font-medium text-gray-700">SUPPLIER NAME or PROPRIETOR</label>
                                                <select name="supplier_id" id="supplier_id" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8">
                                                    <option value="">Select employee</option>
                                                    @foreach ($allSuppliers as $allSupplier)
                                                        <option 
                                                            value="{{ $allSupplier->id }}"
                                                            {{ old('supplier_id', $consolidate->supplier_id) == $allSupplier->id ? 'selected' : '' }}
                                                        >
                                                            {{ $allSupplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>                            
                                                
                                                <x-input label="ADDRESS" name="address" type="text" value="{{ old('address', $consolidate->address) }}" class="bg-gray-50 mb-8" />
                                                
                                                <x-input label="T.I.N. #" name="tin" type="text" value="{{ old('address', $consolidate->tin) }}" class="bg-gray-50 mb-8" />

                                                <div x-data="{
                                                    expenses: '{{ old('expensescategory_id', $consolidate->expensescategory_id) }}',
                                                    nonexpenses: '{{ old('nonexpensescategory_id', $consolidate->nonexpensescategory_id) }}'
                                                }">
                                                    <label for="expensescategory_id" class="font-medium text-gray-700">EXPENSES CATEGORIES</label>
                                                    <select 
                                                        name="expensescategory_id" 
                                                        id="expensescategory_id"
                                                        x-model="expenses"
                                                        :disabled="nonexpenses !== ''"
                                                        class="
                                                                border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8
                                                                disabled:bg-gray-100 disabled:text-gray-500 
                                                                disabled:cursor-not-allowed disabled:border-gray-200
                                                            "
                                                    >
                                                        <option value="">Select expenses category</option>
                                                        @foreach ($allExpensesCategories as $allExpensesCategory)
                                                            <option 
                                                                value="{{ $allExpensesCategory->id }}"
                                                            >
                                                                {{ $allExpensesCategory->expenses }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <label for="nonexpensescategory_id" class="font-medium text-gray-700">NON-EXPENSES CATEGORIES</label>
                                                    <select 
                                                        name="nonexpensescategory_id" 
                                                        id="nonexpensescategory_id"
                                                        x-model="nonexpenses"
                                                        :disabled="expenses !== ''"
                                                        class="
                                                                border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none w-full mb-8
                                                                disabled:bg-gray-100 disabled:text-gray-500 
                                                                disabled:cursor-not-allowed disabled:border-gray-200
                                                                "
                                                    >
                                                        <option value="">Select non-expenses category</option>
                                                        @foreach ($allNonexpensesCategories as $allNonexpensesCategory)
                                                            <option 
                                                                value="{{ $allNonexpensesCategory->id }}"
                                                            >
                                                                {{ $allNonexpensesCategory->nonexpenses }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <x-input label="Net Vat" name="net_vat" type="number" value="{{ old('net_vat', $consolidate->net_vat) }}" class="bg-gray-50 mb-8" />
                                                
                                                <x-input label="Input Vat" name="input_vat" type="number" value="{{ old('input_vat', $consolidate->input_vat) }}" class="bg-gray-50 mb-8" />

                                                <x-input label="Non-Vat(Unreported all here)" name="non_vat" type="number" value="{{ old('non_vat', $consolidate->non_vat) }}"  class="bg-gray-50 mb-8" />

                                                <x-input label="ewt" name="ewt" type="number" value="{{ old('ewt', $consolidate->ewt) }}" class="bg-gray-50 " /> 

                                                <div class="flex justify-end mt-4 gap-3">
                                                    <x-Button type="submit">Save</x-Button>
                                                    <x-Button @click="open = false" variant="danger">Close</x-Button>
                                                </div> 
                                            </form>           
                                        </x-slot>
                                    </x-modal>

                                    <form action="{{ route('consolidates.destroy', $consolidate->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-Button type="submit" variant="danger">Delete</x-Button>
                                    </form>
                                </span>
                            </td>
                            {{--END edit and delete consolidates END--}}
                            <td class="px-6 py-4 border">{{ $consolidate->date_consolidate->format('F-d-Y') }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->pvc ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->employee->name ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->areacustomer->area ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->reported_and_unreported ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->remarks ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->date_receipt->format('F-d-Y') ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->receipt_invoice ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->supplier->name ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->address ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->tin ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ $consolidate->type ?? '' }}</td>
                            <td class="px-6 py-4 border">
                                {{ $consolidate->expensescategory->expenses ?? '' }}
                                {{ $consolidate->nonexpensescategory->nonexpenses ?? '' }}
                            </td>
                            <td class="px-6 py-4 border">{{ number_format($consolidate->gross_amt, 2) ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ number_format($consolidate->net_of_vat, 2) ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ number_format($consolidate->input_vat, 2) ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ number_format($consolidate->non_vat, 2) ?? '' }}</td>
                            <td class="px-6 py-4 border">{{ number_format($consolidate->ewt, 2) ?? '' }}</td>
                        </tr>

                        @php
                            $currentPvc = $consolidate->pvc;
                            $grossTotal += $consolidate->gross_amt ?? 0;
                            $netvatTotal += $consolidate->net_of_vat ?? 0;
                            $inputvatTotal += $consolidate->input_vat ?? 0;
                            $nonvatTotal += $consolidate->non_vat ?? 0;

                        @endphp
                    @endforeach

                    <!-- Last total row for the final PVC group -->
                    <div>
                    @if($currentPvc !== null)
                        <tr class="bg-gray-200 font-bold ">
                                <td class="no-export"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="1" class="border px-3 py-4">Type: {{ ($netvatTotal !== 0 && $inputvatTotal !== 0) ? 'VAT' : 'NV' }}</td>
                                <td class="border"></td> 
                                <td colspan="1" class="border px-2 py-4 text-center">Total Gross Amt: <br/>{{ number_format($grossTotal, 2) }}</td>
                                <td colspan="1" class="border px-2 py-4 text-center">Total net of vat: <br/>{{ number_format($netvatTotal, 2) }}</td>
                                <td colspan="1" class="border px-2 py-4 text-center">Total input vat: <br/>{{ number_format($inputvatTotal, 2) }}</td>
                                <td colspan="1" class="border px-2 py-4 text-center">Total Non Vat: <br/>{{ number_format($nonvatTotal, 2) }}</td>
                                <td class="border"></td>
                        </tr>
                    @endif
                    </tbody>

                    @php
                        $grandTotal_Gross_Amt = $consolidates->sum('gross_amt');
                        $grandTotal_Net_Of_Vat = $consolidates->sum('net_of_vat');
                        $grandTotal_Input_Vat = $consolidates->sum('input_vat');
                        $grandTotal_Non_Vat = $consolidates->sum('non_vat');
                        $grandTotal_EWT = $consolidates->sum('ewt');
                    @endphp           
                    <tfoot>
                        <tr class="font-bold">    
                                <td class="bg-gray-200 no-export"></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                                <td class="bg-gray-200 "></td>
                            <td colspan="1" class="border px-2 py-4 text-center text-red-500 bg-gray-200 ">Grand Total Gross Amt:{{ number_format($grandTotal_Gross_Amt, 2) }}</td>
                            <td colspan="1" class="border px-2 py-4 text-center text-red-500 bg-gray-200 ">Grand Total Net of Vat:{{ number_format($grandTotal_Net_Of_Vat, 2) }}</td>
                            <td colspan="1" class="border px-2 py-4 text-center text-red-500 bg-gray-200 ">Grand Total Input Vat:{{ number_format($grandTotal_Input_Vat, 2) }}</td>
                            <td colspan="1" class="border px-2 py-4 text-center text-red-500 bg-gray-200 ">Grand Total Non Vat:{{ number_format($grandTotal_Non_Vat, 2) }}</td>
                            <td colspan="1" class="border px-3 py-4 text-center text-red-500 bg-gray-200 ">Grand Total EWT:{{ number_format($grandTotal_EWT, 2) }}</span>
                            </td>
                        </tr>
                    </tfoot>          
            </table>
        </div>
        
        <div class="flex my-5 justify-end">
            <table class="" id="serviceReplenishment">  {{-- Total Service Replenishment --}}
                @php
                    $totalVat = $consolidates->where('type', 'VAT')->sum('gross_amt');
                    $totalNv  = $consolidates->where('type', 'NV')->sum('gross_amt');
                    $grandTotal = $totalVat + $totalNv;
                @endphp
                <thead>
                    <tr>
                        <th class="p-3 border" colspan="2">Total Service Replenishment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-3 border">Unreported Reimbursement</td>
                        <td class="p-3 border">{{ number_format($totalNv, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="p-3 border">Reported Reimbursement</td>
                        <td class="p-3 border">{{ number_format($totalVat, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="p-3 border">Grand Total</td>
                        <td class="p-3 border">{{ number_format($grandTotal, 2) }}</td>
                    </tr>                    
                </tbody>
            </table>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="categories">
                <thead class="bg-gray-100 uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3 border">CATEGORIES</th>
                        <th class="px-6 py-3 border">VATABLE</th>
                        <th class="px-6 py-3 border">NON*VAT</th>
                        <th class="px-6 py-3 border">AMOUNT</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            // Step 1 — Merge both category types into a unified collection
                            $merged = collect();

                            foreach ($consolidates as $c) {
                                if ($c->expensescategory) {
                                    $merged->push([
                                        'category' => $c->expensescategory->expenses,
                                        'vat' => $c->input_vat,
                                        'non_vat' => $c->non_vat,
                                    ]);
                                }

                                if ($c->nonexpensescategory) {
                                    $merged->push([
                                        'category' => $c->nonexpensescategory->nonexpenses,
                                        'vat' => $c->input_vat,
                                        'non_vat' => $c->non_vat,
                                    ]);
                                }
                            }

                            // Step 2 — Group and sum both VAT and NON-VAT
                            $grouped = $merged
                                ->groupBy('category')
                                ->map(function ($items) {
                                    return [
                                        'total_vat' => $items->sum('vat'),
                                        'total_non_vat' => $items->sum('non_vat'),
                                    ];
                                });
                        @endphp

                        {{-- Step 3 — Display final grouped results --}}
                        @foreach ($grouped as $category => $data)
                            <tr>
                                <td class="px-6 py-4 border">{{ $category }}</td>
                                <td class="px-6 py-4 border">{{ $data['total_vat'] ?? '-' }} </td>
                                <td class="px-6 py-4 border">{{ $data['total_non_vat'] ?? '-' }}</td>
                                <td class="px-6 py-4 border">{{ number_format($data['total_vat'] + $data['total_non_vat'], 2) ?? '-' }}</td>
                            </tr>
                        @endforeach
                        @php
                            $inputVatTotal = $consolidates->sum('input_vat');
                        @endphp
                        @if ($inputVatTotal !== 0 )
                            <tr>
                                <td class="px-6 py-4 border">Input VAT</td>
                                <td class="px-6 py-4 border"></td>
                                <td class="px-6 py-4 border"></td>
                                <td class="px-6 py-4 border">
                                    {{ number_format($inputVatTotal, 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
            </table>
        </div>
    </div>
@endsection     



