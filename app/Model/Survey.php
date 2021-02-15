<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model{
    protected $table = 'surveys';
    public $timestamps = false;
    protected $primaryKey ='id';  
}
?>