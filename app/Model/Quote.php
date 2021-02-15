<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model{
    protected $table = 'quotes';
    public $timestamps = false;
    protected $primaryKey ='id';  
}
?>