<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Ignored_Email extends Model{
    protected $table = 'ignored_emails';
    public $timestamps = true;
    protected $primaryKey ='id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
?>