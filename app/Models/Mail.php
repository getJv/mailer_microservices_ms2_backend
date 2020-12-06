<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $attributes = ['status' => 'queued'];


    public function bounced(){
        $this->update(['status'=>'bounced']);
    }
    public function delivered(){
        $this->update(['status'=>'delivered']);
    }
    public function failed(){
        $this->update(['status'=>'failed']);
    }
}
