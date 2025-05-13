<?php

namespace App\Models;

use CodeIgniter\Model;

class cadetModel extends Model
{
    protected $table            = 'cadets';
    protected $primaryKey       = 'cadet_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['student_id','school_id','first_name','middle_name','surname','suffix',
                                    'house_no','street','village','municipality','province','course',
                                    'year','section','school_attended','birthdate','height','weight',
                                    'blood_type','gender','religion','contact_no','fb_account','email',
                                    'mother_sname','mother_fname','mother_mname','mother_contact','mother_work',
                                    'father_sname','father_fname','father_mname','father_contact','father_work',
                                    'emergency_house_no','emergency_street','emergency_village','emergency_municipality',
                                    'emergency_province','relationship','emergency_contact','emergency_email',
                                    'token','date_created'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}