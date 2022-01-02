<?php

namespace App\Models;

use App\Entities\Post;
use CodeIgniter\Model;

class Mahasiswa_model extends Model
{
    protected $table = 'mahasiswa';
   

    protected $allowedFields = [
        'nim',
        'nama',
        'kelas',
       
    ];

    // protected $validationRules = [
    //     'title' => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[posts.title,id,{id}]',
    //     'content' => 'required',
    //     'status' => 'required'
    // ];
}