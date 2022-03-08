<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class Product1Export implements FromCollection, WithHeadings
{



    protected $status, $category;

    public function __construct($status, $category)
    {

        $this->status     = $status;
        $this->category     = $category;
    }

    public function headings(): array
    {

        return [

            'id',
            'SKU',
            'user_id',
            'status',
            'category_id',
            'country_id',
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'vendor_price',
            'fixed_price',
            'colors',
            'sizes',
            'stock',
            'images',

        ];
    }


    public function collection()
    {
        return collect(Product::getProducts($this->status, $this->category));
    }
}
