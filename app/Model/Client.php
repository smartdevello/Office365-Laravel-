<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Client extends Model{
    protected $table = 'clients';
    public $timestamps = true;
    protected $primaryKey ='id';
    const CREATED_AT = 'added_at';
    const UPDATED_AT = 'updated_at';
}
?>