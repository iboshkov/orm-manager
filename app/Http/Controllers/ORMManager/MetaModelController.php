<?php

namespace App\Http\Controllers\ORMManager;

use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Providers\ORMHelper;

class MetaModelController extends Controller
{
    protected function getIfExists($key, $arr) {
        if (isset($arr[$key]))
            return $arr[$key];
        return null;
    }

    public static function getModelMeta($model=null, $includeRelations = true) {
        $conn = DB::connection();

        $instance = new $model();
        $attrs = array_unique(array_merge($instance->getFillable(), $instance->getHidden()));
        $tableName = $instance->getTable();

        $relations = $instance->getRelationships();

        $primaryKey = $instance->getKeyName();
        //$posts = get_class($instance->{$relations[0]}()->getRelated());
        $types = array_map(function($attr) use ($tableName, $conn) {
            return $conn->getDoctrineColumn($tableName, $attr)->getType()->getName();
        }, $attrs);



        $attributeTypeMap = array_map(function($k, $v) {
            return array("name" => $k, "type" => $v, "humanName" => humanize_attribute($k));
        }, $attrs, $types);

        $relatedModels = array_map(function($rel) use ($instance, & $attributeTypeMap) {
            $relation = $instance->{$rel}();

            $relatedModel = $relation->getRelated();

            $relationType = explode('\\', get_class($relation));

            $result = array(
                "name" => $rel,
                "model" => get_class($relatedModel),
                "type" => array_pop($relationType)
            );

            $foreign = null;

            if (method_exists($relation, "getForeignKey"))
                $result["foreignKey"] = $relation->getForeignKey();
            if (method_exists($relation, "getQualifiedForeignKey"))
                $result["foreignKeyFull"] = $relation->getQualifiedForeignKey();
            if (method_exists($relation, "getPlainForeignKey"))
                $result["foreignKeyPlain"] = $relation->getPlainForeignKey();
            if (method_exists($relation, "getOtherKey"))
                $result["otherKey"] = $relation->getOtherKey();
            if (method_exists($relation, "getQualifiedOtherKeyName"))
                $result["otherKeyFull"] = $relation->getQualifiedOtherKeyName();
            if (method_exists($relation, "getParentKey"))
                $result["parentKey"] = $relation->getParentKey();
            if (method_exists($relation, "getQualifiedParentKeyName"))
                $result["parentKeyFull"] = $relation->getQualifiedParentKeyName();
            $foreign = $result["foreignKey"] ?: $result["foreignKeyPlain"];
            if ($foreign) {
                $toDelete = -1;
                foreach($attributeTypeMap as $idx => $val) {
                    if ($val["name"] === $foreign)
                    {
                        $toDelete = $idx;
                    }
                }

                if ($toDelete >= 0) {
                    unset($attributeTypeMap[$toDelete]);
                }
            }


            return $result;
        }, $relations);

        $relationModelMap = array_combine($relations, $relatedModels);

        return array(
            "class" => $model,
            "primaryKey" => $primaryKey,
            "attributes" => array_values($attributeTypeMap),
            "relationships" => array_values($relationModelMap)
        );
    }

    public function getModelMetaRoute(Request $request) {
        return $this->getModelMeta($request["class"]);
    }

    public function getModels()
    {
        $models = config("orm.models");
        $metaData = array();

        foreach($models as $model) {
            $data = $this->getModelMeta($model);
            array_push($metaData, $data);
        }

        $modelMap = array_combine($models, $metaData);

        return $models;
    }


    public function showDashboard()
    {
        $models = $this->getModels();
        return view('orm_manager.dashboard', ['models' => $models]);
    }

    public function showModels()
    {
        $models = $this->getModels();
        return view('orm_manager.app', ['models' => $models]);
    }

}
