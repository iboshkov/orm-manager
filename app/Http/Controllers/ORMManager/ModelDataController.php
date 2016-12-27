<?php

namespace App\Http\Controllers\ORMManager;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Providers\ORMHelper;
use App\Http\Controllers\ORMManager\MetaModelController;


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

    public function createEntry(Request $request) {
        return "Create";
    }

    public function updateEntry(Request $request) {
        $modelClass = $request->input("class");
        $modelData = $request->input("data");
        $meta = MetaModelController::getModelMeta($modelClass);
        $primaryKeyField = $meta["primaryKey"];
        $primaryKeyData = $modelData[$primaryKeyField];

        $foundModel = $modelClass::findOrFail($primaryKeyData);
        $foundModel->fill($modelData);

        /*
        foreach ($meta->attributes as $attribute) {
            echo $foundModel;
            $foundModel[$attribute] = $modelData[$attribute];
        }*/

        $foundModel->save();

        return $foundModel;
    }

    public function deleteEntry(Request $request) {
        return "Delete";
    }


}
