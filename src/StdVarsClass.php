<?php

namespace sdavis1902\EloquentVars;

use stdClass;

class StdVarsClass extends stdClass {
    public function __get($field){
        if(!isset($this->{$field})){
            return null;
        }
    }
}
