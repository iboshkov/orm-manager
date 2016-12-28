<?php

namespace App\Http\Controllers\ORMManager;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Providers\ORMHelper;
use App\Http\Controllers\ORMManager\MetaModelController;
use Carbon\Carbon;

class ModelDataController extends Controller
{
    const ACTION_CREATE = 0;
    const ACTION_DELETE = 1;
    const ACTION_UPDATE = 2;
    const DATETIME_FORMAT = "Y-m-d H:i:s";
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
        return $this->handleRequest($request, self::ACTION_CREATE);
    }

    public function handleRequest(Request $request, $action) {
        $modelClass = $request->input("class");
        $modelData = $request->input("data");
        $meta = MetaModelController::getModelMeta($modelClass);
        if ($action === self::ACTION_DELETE || $action == self::ACTION_UPDATE) {
            $primaryKeyField = $meta["primaryKey"];
            $primaryKeyData = $modelData[$primaryKeyField];
            $foundModel = $modelClass::findOrFail($primaryKeyData);
        }

        if ($action == self::ACTION_DELETE) {
            $foundModel->delete();
        } else if ($action == self::ACTION_UPDATE) {
            $foundModel->fill($modelData);
            $foundModel->save();
        } else if ($action === self::ACTION_CREATE) {
            var_dump($meta);
            $newModel = new $modelClass();

            foreach ($meta["attributes"] as $attr) {
                $actualAttr = $attr["name"];
                if ($attr["type"] == "datetime") {
                    echo "Data: " . $modelData[$actualAttr];
                    $newModel->$actualAttr = Carbon::createFromFormat(self::DATETIME_FORMAT, $modelData[$actualAttr]);
                } else {
                    $newModel->$actualAttr = $modelData[$actualAttr];
                }
            }

            //$newModel->fill($modelData);
            $newModel->save();
            return $newModel;
        }

        return $foundModel;
    }

    public function updateEntry(Request $request) {
        return $this->handleRequest($request, self::ACTION_UPDATE);
    }

    public function deleteEntry(Request $request) {
        return $this->handleRequest($request, self::ACTION_DELETE);
    }

    public function deleteAll(Request $request) {
        $modelClass = $request->input("class");
        $modelClass::getQuery()->delete();
    }
}
