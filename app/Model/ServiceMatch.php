<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ServiceMatch extends Model{
    protected $table = 'service_match';
    public $timestamps = false;
    protected $primaryKey ='service_match_id';  
}
?>