<?php

namespace App\Http\Controllers;

use Defrindr\Crudify\Helpers\ResponseHelper;

class ExampleController extends Controller
{
    public function dropdown()
    {
        $items = [];

        for ($i = 0; $i < 20; $i++) {
            array_push($items, [
                'key' => $i,
                'label' => "Item ke-$i",
            ]);
        }

        return ResponseHelper::successWithData([
            'selected' => null,
            'items' => $items,
        ]);
    }
}
