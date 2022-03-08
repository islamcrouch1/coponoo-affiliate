<?php

namespace App\Imports;

use App\Category;
use App\Color;
use App\Country;
use App\Log;
use App\Product;
use App\ProductImage;
use App\Size;
use App\Stock;
use App\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\Failure;
use Intervention\Image\ImageManagerStatic as Image;

use Throwable;

class ProductImport implements
    WithValidation,
    WithHeadingRow,
    ToCollection,
    SkipsOnError,
    SkipsOnFailure,
    SkipsEmptyRows
// WithChunkReading,
// ShouldQueue,
// WithEvents
{


    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;





    public function rules(): array
    {
        return [

            'name_ar' => "required|string",
            'name_en' => "required|string",
            'sku' => "nullable|string|unique:products",
            'images' => "required|string",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|numeric",
            'categories' => "required",
            'status' => "required|string",
            'colors'  => "required",
            'sizes'  => "required",
            'fixed_price'  => "nullable|numeric",
            'stock' => "required",

        ];
    }


    public function chunkSize(): int
    {
        return 1000;
    }


    public function collection(Collection $rows)
    {





        foreach ($rows as $row) {


            Validator::make($row->toArray(), [
                'name_ar' => "required|string",
                'name_en' => "required|string",
                'sku' => "required|string|unique:products",
                'images' => "required|string",
                'description_ar' => "required|string",
                'description_en' => "required|string",
                'vendor_price' => "required|numeric",
                'categories' => "required",
                'status' => "required|string",
                'colors'  => "required",
                'sizes'  => "required",
                'fixed_price'  => "nullable|numeric",
                'stock' => "required",
            ])->validate();



            if (User::find($row['user_id']) != NULL) {

                $vendor = User::find($row['user_id']);

                if (!$vendor->hasRole('vendor')) {
                    if (app()->getLocale() == 'ar') {
                        return back()->withStatus('رقم التاجر المدخل غير صحيح');
                    } else {
                        return back()->withStatus('The vendor number entered is incorrect');
                    }
                }
            } else {


                if (app()->getLocale() == 'ar') {
                    return back()->withStatus('رقم التاجر المدخل غير صحيح');
                } else {
                    return back()->withStatus('The vendor number entered is incorrect');
                }
            }






            if ($row['images'] == '') {
                if (app()->getLocale() == 'ar') {
                    return back()->withStatus('الحقل الخاص برابط الصور مطلوب , لايمكن تركه فارغا');
                } else {
                    return back()->withStatus('The image link field is required, it cannot be left blank');
                }
            }


            if (Country::where('id', $row['country_id'])->count() == 0) {
                if (app()->getLocale() == 'ar') {
                    return back()->withStatus('رقم الدولة المستخدم غير صحيح يرجى مراجعة البيانات');
                } else {
                    return back()->withStatus('The country id used is incorrect, please check the data');
                }
            }



            $colors = explode(',', $row['colors']);
            $sizes = explode(',', $row['sizes']);
            $stocks = explode(',', $row['stock']);
            $categories = explode(',', $row['categories']);

            foreach ($colors as $color) {

                if (Color::where('id', $color)->count() == 0) {


                    if (app()->getLocale() == 'ar') {
                        return back()->withStatus('رقم اللون المستخدم غير صحيح يرجى مراجعة البيانات');
                    } else {
                        return back()->withStatus('The color id used is incorrect, please check the data');
                    }
                }
            }


            foreach ($sizes as $size) {

                if (Size::where('id', $size)->count() == 0) {


                    if (app()->getLocale() == 'ar') {
                        return back()->withStatus('رقم المقاس المستخدم غير صحيح يرجى مراجعة البيانات');
                    } else {
                        return back()->withStatus('The size id used is incorrect, please check the data');
                    }
                }
            }
        }




        foreach ($rows as $row) {

            if (isset($row['fixed_price'])) {

                $fixed_price = str_replace(' ', '', $row['fixed_price']);
            } else {
                $fixed_price = 0;
            }


            $categories = explode(',', $row['categories']);


            $average = 0;
            $count = 0;


            foreach ($categories as $category) {
                $category = Category::find($category);
                $average += ceil($category->profit);
                $count++;


                if (Category::where('id', $category->id)->count() == 0) {


                    if (app()->getLocale() == 'ar') {
                        return back()->withStatus('رقم القسم المستخدم غير صحيح يرجى مراجعة البيانات');
                    } else {
                        return back()->withStatus('The category id used is incorrect, please check the data');
                    }
                }
            }

            $average = ceil($average / $count);

            $price =  ceil($row['vendor_price'] *  ceil($average) / 100);


            $price = $price + ceil($fixed_price);

            $price1 = $price;


            $price = ceil($price * setting('tax') / 100);

            $price = $price + $price1;



            $total_profit = $price;


            $price = $price + ceil($row['vendor_price']);





            $max_price = ceil($price * setting('max_price') / 100);


            if (Auth::user()->HasRole('vendor')) {

                $product = Product::create([
                    'user_id' => Auth::id(),
                    'name_ar' => $row['name_ar'],
                    'name_en' => $row['name_en'],
                    'SKU' => str_replace(' ', '', $row['sku']),
                    'description_ar' => $row['description_ar'],
                    'description_en' => $row['description_en'],
                    'vendor_price' => ceil(str_replace(' ', '', $row['vendor_price'])),
                    'min_price' => ceil($price),
                    'max_price' => ceil($max_price),
                    'fixed_price' => ceil($fixed_price),
                    'total_profit' => ceil($total_profit),
                    // 'stock' => $row['stock'],
                    'category_id' => 0,
                    'country_id' => $category->country->id,
                    'status' => 'pending',
                    'price' => $price,

                ]);


                $product->categories()->attach($categories);


                $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->SKU . ' - ' . ' تم إضافة هذا المنتج من الشيت';
                $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->SKU . ' - ' . ' This product was added from the sheet';

                $log = Log::create([

                    'user_id' => Auth::id(),
                    'user_type' => 'vendor',
                    'log_type' => 'products',
                    'description_ar' => $description_ar,
                    'description_en' => $description_en,

                ]);
            } else {
                $product = Product::create([
                    'user_id' => $row['user_id'],
                    'name_ar' => $row['name_ar'],
                    'name_en' => $row['name_en'],
                    'SKU' => str_replace(' ', '', $row['sku']),
                    'description_ar' => $row['description_ar'],
                    'description_en' => $row['description_en'],
                    'vendor_price' => ceil(str_replace(' ', '', $row['vendor_price'])),
                    'min_price' => ceil($price),
                    'max_price' => ceil($max_price),
                    'fixed_price' => ceil($fixed_price),
                    'total_profit' => ceil($total_profit),
                    // 'stock' => $row['stock'],
                    'category_id' => 0,
                    'country_id' => $category->country->id,
                    'status' => str_replace(' ', '', $row['status']),
                    'price' => $price,
                    'vendor_id' => Auth::id(),

                ]);



                $product->categories()->attach($categories);


                $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $product->id . ' - SKU ' . $product->SKU . ' - ' . ' تم إضافة هذا المنتج من الشيت';
                $description_en  = "product added " . " product ID " . ' #' . $product->id . ' - SKU ' . $product->SKU . ' - ' . ' This product was added from the sheet';

                $log = Log::create([

                    'user_id' => Auth::id(),
                    'user_type' => 'admin',
                    'log_type' => 'products',
                    'description_ar' => $description_ar,
                    'description_en' => $description_en,

                ]);
            }





            $images = explode(',', $row['images']);



            foreach ($images as $image) {


                try {
                    $url = $image;
                    $contents = file_get_contents($url);
                    $name = substr($url, strrpos($url, '/') + 1);

                    $rand = rand();

                    // resize(300, null, function ($constraint) {
                    //     $constraint->aspectRatio();
                    // })->

                    Image::make($contents)->save(public_path('storage/images/products/' . $rand  . ' - ' . $row['sku'] . $name), 80);

                    ProductImage::create([

                        'product_id' => $product->id,
                        'url' => $rand . ' - ' . $row['sku'] . $name,
                    ]);
                } catch (Exception $e) {
                }
            }




            $colors = explode(',', $row['colors']);
            $sizes = explode(',', $row['sizes']);
            $stocks = explode(',', $row['stock']);



            foreach ($colors as $color) {

                foreach ($sizes as $size) {


                    $stock = Stock::create([

                        'color_id' => $color,
                        'size_id' => $size,
                        'product_id' => $product->id,
                        'stock' => 0,

                    ]);
                }
            }

            foreach ($product->stocks as $index => $product_stock) {


                $product_stock->update([
                    'stock' => isset($stocks[$index]) ? $stocks[$index] : '0',
                ]);
            }



            // $product->address()->create([
            //     'country' => $row['country']
            // ]);



        }
    }



    // public static function afterImport(AfterImport $event)
    // {
    // }

    // public function onFailure(Failure ...$failure)
    // {
    // }


}
