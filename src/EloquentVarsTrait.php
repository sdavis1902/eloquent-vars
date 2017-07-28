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

    public static function bootEloquentVarsTrait(){
        static::saved(function($model){
            if(empty($model->vars)){
                return true; // nothign to do, lets exit
            }

            foreach($model->vars as $key => $value){
                $model->setVar($key, $value);
            }
        });
    }
}
