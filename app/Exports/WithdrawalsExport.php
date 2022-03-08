<?php

namespace App\Exports;

use App\Withdrawal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class WithdrawalsExport implements FromCollection, WithHeadings
{

    protected $status, $from, $to;

    public function __construct($status, $from, $to)
    {

        $this->status     = $status;
        $this->from     = $from;
        $this->to     = $to;
    }

    public function headings(): array
    {

        return [
            'id',
            'name',
            'data',
            'amount',
            'status',
            'created_at',
            'type',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(Withdrawal::getWithdrawal($this->status, $this->from, $this->to));
    }
}
