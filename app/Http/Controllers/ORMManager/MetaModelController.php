<?php

namespace App\Http\Controllers\ORMManager;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Providers\ORMHelper;

class MetaModelController extends Controller
{

    protected function getModelMeta($model, $includeRelations = true) {
        $conn = DB::connection();

        $instance = new $model();
        $attrs = array_merge($instance->getFillable(), $instance->getHidden());
        $tableName = $instance->getTable();

        $relations = $instance->getRelationships();

        $relatedModels = array_map(function($rel) use ($instance) {
            return get_class($instance->{$rel}()->getRelated());
        }, $relations);

        $relationModelMap = array_combine($relations, $relatedModels);

        //$posts = get_class($instance->{$relations[0]}()->getRelated());
        $types = array_map(function($attr) use ($tableName, $conn) {
            return $conn->getDoctrineColumn($tableName, $attr)->getType()->getName();
        }, $attrs);

        $attributeTypeMap = array_combine($attrs, $types);

        return array(
            "attributes" => $attributeTypeMap,
            "relationships" => $relationModelMap
        );
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

        return $modelMap;
    }


    public function showDashboard()
    {
        $models = $this->getModels();
        return view('orm_manager.dashboard', ['models' => $models]);
    }

    public function showModels()
    {
        $models = $this->getModels();
        return view('orm_manager.models', ['models' => $models]);
    }

}
