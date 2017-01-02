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
        $meta = MetaModelController::getModelMeta($modelClass);
        $relationNames = [];
        foreach ($meta["relationships"] as $rel) {
            $rname = $rel["name"];
            array_push($relationNames, $rname);

        }


        $models = $modelClass::with($relationNames)->get();

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
        $primaryKeyField = $meta["primaryKey"];
        $modelInstance = null;
        
        if ($action === self::ACTION_DELETE || $action == self::ACTION_UPDATE) {
            $primaryKeyData = $modelData[$primaryKeyField];
            $modelInstance = $modelClass::findOrFail($primaryKeyData);
        }
        

        if ($action == self::ACTION_DELETE) {
            $modelInstance->delete();
        } else if ($action == self::ACTION_UPDATE) {
            $modelInstance->fill($modelData);
            $modelInstance->save();
        } else if ($action === self::ACTION_CREATE) {
            var_dump($meta);
            $modelInstance = new $modelClass();

            foreach ($meta["attributes"] as $attr) {
                $actualAttr = $attr["name"];
                if ($actualAttr == $primaryKeyField)
                    continue;

                // Todo: handle other special cases

                if ($attr["type"] == "datetime") {
                    echo "Data: " . $modelData[$actualAttr];
                    $modelInstance->$actualAttr = Carbon::createFromFormat(self::DATETIME_FORMAT, $modelData[$actualAttr]);
                } else {
                    $modelInstance->$actualAttr = $modelData[$actualAttr];
                }
            }


            /*
            foreach ($meta["relationships"] as $rel) {
                $relType = $rel["type"];
                $relName = $rel["name"];
                $otherModelClass = $rel["model"];

                if ($relType == "BelongsTo") {
                    $otherModelKey = $rel["otherKey"];
                    $foreignKeyField = $rel["foreignKey"];
                    $foreignKey = $modelData[$foreignKeyField];

                    $otherModel = $otherModelClass::find($foreignKey);
                    $modelInstance->$relName()->associate($otherModel);
//                    $otherModel->$relName()->associate($modelInstance);
//                    $otherModel->save();
                }                
            }
            */
            
            //$modelInstance->fill($modelData);

        }

        if ($action == self::ACTION_CREATE || $action == self::ACTION_UPDATE) {
            $rels = $modelData["relationships"];

            foreach ($rels as $relName => $relData) {
                $rtype = $relData["type"] ;
                $otherModelKey = $relData["param"];
                $otherModelClass = $relData["model"];
                if ($rtype == "BelongsTo") {
                    $otherModel = $otherModelClass::find($otherModelKey);

                    $modelInstance->$relName()->associate($otherModel);
                } 
            }

            $modelInstance->save();

            // Deal with the relationships that require an id.
            foreach ($rels as $relName => $relData) {
                $rtype = $relData["type"] ;
                $otherModelKey = $relData["param"];
                $otherModelClass = $relData["model"];
                
                if ($rtype == "BelongsToMany") {
                  var_dump($otherModelKey);
                  $modelInstance->$relName()->sync($otherModelKey);
                }

                if ($rtype == "HasMany") {
                  $otherModelMeta = MetaModelController::getModelMeta($otherModelClass);
                  $otherPkey = $otherModelMeta["primaryKey"];
                  $currentItems = $modelInstance->$relName()->get();
                  $fkey = $relData["foreignKeyPlain"];
                  $thisKey = $modelInstance[$primaryKeyField];

                  foreach ($currentItems as $item) {
                    // TODO: Make models with nullable attributes dangle.
                    //$item[$fkey] = $modelInstance[$primaryKeyField];
                    $key = $item[$otherPkey];
                    
                    // Now in new items, delete it.
                    if (!in_array($key, $otherModelKey)) {
                      $item->delete();
                    } 
                  }
                  
                  //$currentItems->update([$fkey => null]);
                  $newItems = $otherModelClass::find($otherModelKey);
                  foreach ($newItems as $item) {
                    $item[$fkey] = $modelInstance[$primaryKeyField];
                    $item->save();
                  }
                  //return $newItems;

                  //$newItems->update([$fkey => $modelInstance[$primaryKeyField]]);
                  
                  /* foreach ($currentItems as $item) {
                    $item->setAttribute($fkey, null);
                  }*/
                  //return $currentItems->get();// $otherModelClass::find($otherModelKey);//$modelInstance->$relName()->associate($relData["param";
                  $modelInstance->save();
                }
            }


            
            return $modelInstance;
        } 

        return $modelInstance;
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
