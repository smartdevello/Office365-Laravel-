<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model{
    protected $table = 'expenses';
    protected $primaryKey ='expenses_id';  
}
?>