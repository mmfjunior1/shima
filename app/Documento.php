<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Documento extends Model
{
    //
	protected $table 		= 'documentos';
	protected $primaryKey	= 'id_documento';
	protected $fillable		= ['titulo','arquivo','id_cliente'];
	

}
