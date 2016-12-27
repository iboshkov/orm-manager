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
    const ACTION_CREATE = 0;
    const ACTION_DELETE = 1;
    const ACTION_UPDATE = 2;

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
        if ($action === self::ACTION_DELETE || $action == self::ACTION_UPDATE) {
            $meta = MetaModelController::getModelMeta($modelClass);
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
            $newModel = new $modelClass();
            $newModel->fill($modelData);
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
