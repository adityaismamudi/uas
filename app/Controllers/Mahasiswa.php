<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Mahasiswa_model;
use Config\Validation;
class Mahasiswa extends ResourceController
{

protected $format = 'json';

 public function create(){
       $validation = \Config\Services::validation();
         if (!$this->validate([
            'nim' => 'required|is_unique[mahasiswa.nim]',
             'kelas' => 'required',
              'nama' => 'required',
        ])) {
            $errors = $validation->getErrors();
              $response = [
                'status'   => 403,
                'error'    => true,
                'messages' => $errors
                
            ];
             return $this->respond($response, 403);
 
        }
         $mahasiswa_model = new Mahasiswa_model();
        $data = [
            'nim' => $this->request->getPost('nim'),
            'kelas' => $this->request->getPost('kelas'),
            'nama' => $this->request->getPost('nama')
        ];
        $mahasiswa_model->insert($data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Mahsiswa Berhasil disimpan'
            ],
            'data'=>$data
        ];
        return $this->respond($response, 200);
    }

    

public function read($nim = null){
 $mahasiswa_model = new Mahasiswa_model();
        if($nim !== null){
        $data = $mahasiswa_model->where('nim',$nim)->find();
        if(!$data){

            $response = [
                'status'   => 403,
                'error'    => true,
                'messages' => [
                    'success' => 'Tidak ada mahasisawa dengan nim '.$nim
                ]
            ];
             return $this->respond($response, 201);
        }
        }else{
        $data = $mahasiswa_model->findAll();
        $response = [
                'status'   => 200,
                'data'=>$data
            ];
        }
        return $this->respond($data, 200);
    }



    public function update($nim= null){
         $json = $this->request->getJSON();
        if($json){
            $data = [
                'kelas' => $json->kelas,
                'nama' => $json->nama
            ];
        }else{
            $input = $this->request->getRawInput();
            $data = [
                'kelas' => $input['kelas'],
                'nama' => $input['nama']
            ];
        }
          $mahasiswa_model = new Mahasiswa_model();
        $mahasiswa_model->where('nim', $nim)->set($data)->update();
        $mahasiswa = $mahasiswa_model->where('nim',$nim)->find();
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Mahsiswa Berhasil diperbarui'
            ],
            'data'=>$mahasiswa
        ];
        return $this->respond($response, 200);
    }



    
    public function delete($nim=null){
           $mahasiswa_model = new Mahasiswa_model();
                $mahasiswa_model->where('nim', $nim)->delete();
                $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Mahsiswa Berhasil dihapus'
            ]
        ];
        return $this->respond($response, 200);
    }

}