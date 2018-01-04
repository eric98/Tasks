<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name','description', 'user_id', 'completed'];

//    protected $timestamps = true;

    public function toArray()
    {
//        dd($this->created_at);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'completed' => $this->completed? true:false,
            'created_at' => $this->created_at."",
            'updated_at' => $this->updated_at."",
        ];
    }
}
