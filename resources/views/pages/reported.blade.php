@extends('main')

@section('title', 'Reported')

@section('content')

    <table id="transmitalSlip_reported_unreported">
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
                    <td class="font-bold">REPORTED</td>
                </tr>
            </tfoot>
    </table>

    <div class="text-center">
        <x-Button onclick="downloadReports()">Export to Excel</x-Button>
    </div>

   <div class="overflow-x-auto mt-1">
        <table class="min-w-full divide-y divide-gray-200" id="reported_unreportedTable">
                <thead class="bg-gray-100 uppercase text-gray-700">
                    <tr>
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

                @foreach ($reports as $report)
                    @if ($currentPvc !== null && $currentPvc != $report->pvc)
                        <!-- Output total row for previous PVC -->
                            <tr class="bg-gray-200 font-bold ">
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
                        {{--END edit and delete reports END--}}
                        <td class="px-6 py-4 border">{{ $report->date_consolidate->format('F-d-Y') ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->pvc ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->employee->name ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->areacustomer->area ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->reported_and_unreported ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->remarks ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->date_receipt->format('F-d-Y') ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->receipt_invoice ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->supplier->name ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->address ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->tin ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ $report->type ?? '' }}</td>
                        <td class="px-6 py-4 border">
                            {{ $report->expensescategory->expenses ?? '' }}
                            {{ $report->nonexpensescategory->nonexpenses ?? '' }}
                        </td>
                        <td class="px-6 py-4 border">{{ number_format($report->gross_amt, 2) ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ number_format($report->net_of_vat, 2) ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ number_format($report->input_vat, 2) ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ number_format($report->non_vat, 2) ?? '' }}</td>
                        <td class="px-6 py-4 border">{{ number_format($report->ewt, 2) ?? '' }}</td>
                    </tr>

                    @php
                        $currentPvc = $report->pvc;
                        $grossTotal += $report->gross_amt ?? 0;
                        $netvatTotal += $report->net_of_vat ?? 0;
                        $inputvatTotal += $report->input_vat ?? 0;
                        $nonvatTotal += $report->non_vat ?? 0;

                    @endphp
                @endforeach

                <!-- Last total row for the final PVC group -->
                <div>
                @if($currentPvc !== null)
                        <tr class="bg-gray-200 font-bold ">
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
                    $grandTotal_Gross_Amt = $reports->sum('gross_amt');
                    $grandTotal_Net_Of_Vat = $reports->sum('net_of_vat');
                    $grandTotal_Input_Vat = $reports->sum('input_vat');
                    $grandTotal_Non_Vat = $reports->sum('non_vat');
                    $grandTotal_EWT = $reports->sum('ewt');
                @endphp           
                <tfoot>
                    <tr class="font-bold">    
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
    <div class="flex justify-end items-center gap-60">
        <div class="flex gap-30 ">
            <table id="preparedBy">
                <thead>
                    <tr>
                        <th width="200" class="text-center">Prepared by:</th>
                        <th width="200" class="text-center">Approved by:</th>
                        <th width="200" class="text-center"> Approved by:</th>
                    </tr>
                </thead>
                <tbody>
                    <td width="200" class="text-center">Rochelle Fernandez</td>
                    <td width="200" class="text-center">Sir Lito Uy</td>
                    <td width="200" class="text-center">Ms. Leigh De Leon</td>
                </tbody>
            </table>
        </div>
        <div class="flex my-5 justify-end">
            <table class="" id="serviceReplenishmentreported_unreported">  {{-- Total Service Replenishment --}}
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
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="categories_reported_unreported">
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

                        foreach ($reports as $c) {
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

@endsection     