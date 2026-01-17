<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consolidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_consolidate',
        'pvc',
        'date_receipt',
        'receipt_invoice',
        'reported_and_unreported',
        'remarks',
        'address',
        'tin',
        'type',
        'gross_amt',    
        'net_vat',
        'input_vat',
        'non_vat',
        'ewt',
        'employee_id',
        'areacustomer_id',
        'expensescategory_id',
        'nonexpensescategory_id',
        'supplier_id'
    ];

    protected $casts = [
        'date_consolidate' => 'date',
        'date_receipt' => 'date'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function areacustomer(){
        return $this->belongsTo(Areacustomer::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function expensescategory(){
        return $this->belongsTo(Expensescategory::class);
    }

    public function nonexpensescategory(){
        return $this->belongsTo(Nonexpensescategory::class);
    }
}
