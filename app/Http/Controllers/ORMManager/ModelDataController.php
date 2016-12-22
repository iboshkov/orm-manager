<?php

namespace App\Http\Controllers\ORMManager;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Providers\ORMHelper;

class ModelDataController extends Controller
{

    public function getAll(Request $request)
    {
        $modelClass = $request["class"];
        $models = $modelClass::all();

        foreach ($models as $minst) {
            $minst->makeVisible($minst->getHidden());
        }
        return $models;
    }


}
