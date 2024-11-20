<?php

namespace App\Traits;

trait Errors
{
    public function compileErrors(array $errors){
        $result = [];
        foreach ($errors as $error){
            $result[] = $this->compileErrorFromArray($error);
        }
        return $result;
    }

    public function compileErrorFromArray(array $error){
        return $this->compileError($error[0], $error[1], $error[2]);
    }

    public function compileError(
        string $code,
        string $message,
        string $field = '')
    {
        $error = new \stdClass();
        $error->code = $code;
        $error->message = $message;
        $error->field = $field;
        return $error;
    }
}
