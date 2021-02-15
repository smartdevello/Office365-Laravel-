<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model{
    protected $table = 'approval';
    public $timestamps = false;
    protected $primaryKey ='approval_id';  
}
?>