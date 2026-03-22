<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductPhoto;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] === 'ID') return null; // skip header

        return new Product([
            'id'          => $row[0],
            'name'        => $row[1],
            'brand'       => $row[2],
            'category'    => $row[3],
            'description' => $row[4],
            'price'       => $row[5],
            'stock'       => $row[6],
            'created_at'  => \Carbon\Carbon::parse($row[7]),
        ]);

        // Save product first so we can attach photos
        $product->save();

        // Handle multiple photos (comma-separated)
        if (!empty($row[8])) {
            $photos = explode(',', $row[8]);
            foreach ($photos as $photo) {
                $product->photos()->create([
                    'path' => trim($photo)
                ]);
            }
        }

        return $product;
    }
}
