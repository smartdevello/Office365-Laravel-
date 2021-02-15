<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class ClientHistory extends Model{
	protected $table = 'client_history';
	public $timestamps = false;
    protected $primaryKey ='id';
}
?>