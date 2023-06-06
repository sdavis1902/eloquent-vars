<?php
namespace sdavis1902\EloquentVars;

use sdavis1902\EloquentVars\ModelVar;
use sdavis1902\EloquentVars\StdVarsClass;

trait EloquentVarsTrait {

    private $vars;

    public function ModelVars(){
        return $this->hasMany('sdavis1902\EloquentVars\ModelVar', 'model_id')->where('table', '=', $this->getTable());
    }

    public function setVar( $key, $value ){
        if( !$value ) return false;
        if(empty($this->attributes['id'])) return false;
        if ($this->vars) {
            $this->vars->{$key} = $value;
        }
        $var = ModelVar::where('model_id', '=', $this->attributes['id'])->where('key', '=', $key)->where('table', '=', $this->getTable())->first();
        if( $var ){
            $var->value = $value;
            $var->save();
        }else{
            $var = new ModelVar;
            $var->model_id = $this->attributes['id'];
            $var->key = $key;
            $var->value = $value;
            $var->table = $this->getTable();
            $var->save();
        }
    }

    public function getVar( $key ){
        if(empty($this->attributes['id'])) return false;
        $var = ModelVar::where('model_id', '=', $this->attributes['id'])->where('key', '=', $key)->where('table', '=', $this->getTable())->first();
        return $var ? $var->value : false;
    }

	public function deleteVar($key){
        if(empty($this->attributes['id'])) return false;
        if ($this->vars) {
            unset($this->vars->{$key});
        }
        ModelVar::where('model_id', '=', $this->attributes['id'])->where('key', '=', $key)->where('table', '=', $this->getTable())->delete();
	}

    public function getVarsAttribute(){
        if(!empty($this->vars)){
            return $this->vars;
        }

        $vars = new StdVarsClass();
        foreach($this->ModelVars as $var){
            $vars->{$var->key} = $var->value;
        }

        $this->vars = $vars;

        return $this->vars;
    }

    public function saveAllVars(){
        if (empty($this->vars) || empty($this->attributes['id'])) {
            return true;
        }

        $model_id = $this->attributes['id'];
        $table    = $this->getTable();
        $vars     = []; // prepare a list of vars' to insert/update
        foreach ($this->vars as $key => $value) {
            $vars[$key] = [
                "key"      => $key,
                "value"    => $value,
                "table"    => $table,
                "model_id" => $model_id,
                "id"       => null,
            ];
        }

        // fill out primary key IDs for any existing vars,
        // to have ::upsert update them instead of creating new
        $vars_in_db = ModelVar::where('model_id', '=', $model_id)
            ->where('table', '=', $table)
            ->whereIn('key', array_keys((array) $this->vars))
            ->select('id', 'key')->get()->toArray();
        foreach ($vars_in_db as $var_in_db) {
            $vars[$var_in_db["key"]]["id"] = $var_in_db["id"];
        }

        ModelVar::upsert(array_values($vars), ["id"], ["value"]);

        return true;
    }

    public static function bootEloquentVarsTrait(){
        static::saved(function($model){
            return $model->saveAllVars();
        });
    }
}
