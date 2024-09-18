<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingStudent extends Model
{
    protected $table = 'grading_student';

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	protected $fillable = [
		'user_id',
		'partner_id',
		'laporan',
		'final_project',
		'note',
		'status'
	];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function m_partner(){
		return $this->belongsTo(MPartner::class, 'partner_id');
	}	
}
