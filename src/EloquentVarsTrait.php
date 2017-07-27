<?php
namespace sdavis1902\EloquentVars;

use sdavis1902\EloquentVars\ModelVar;

trait EloquentVarsTrait {
    public function setVar( $key, $value ){
        if( !$value ) return;
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
        $var = ModelVar::where('model_id', '=', $this->attributes['id'])->where('key', '=', $key)->where('table', '=', $this->getTable())->first();
        return $var ? $var->value : false;
    }

	public function deleteVar($key){
        ModelVar::where('model_id', '=', $this->attributes['id'])->where('key', '=', $key)->where('table', '=', $this->getTable())->delete();
	}
}
