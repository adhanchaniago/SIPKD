<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model{

  private $nama_tb = 'user';
  private $nama_pk = 'user.kd_dosen';

  public function get_all_user(){
    //https://stackoverflow.com/questions/12126991/cast-from-varchar-to-int-mysql
    $this->datatables->select('user.kd_dosen, nm_dosen, CAST(user.hak_akses AS UNSIGNED) as hak_akses');
    $this->datatables->from($this->nama_tb);
    $this->datatables->join('dosen','dosen.kd_dosen=user.kd_dosen');
    $this->datatables->add_column('view','<a href='.site_url('user/update/$1').' class="btn btn-success">Update</a>','kd_dosen');
    return $this->datatables->generate();
  }

  public function tampil(){
    $this->db->from($this->nama_tb);
    $this->db->join('dosen','dosen.kd_dosen=user.kd_dosen');
    return $this->db->get()->result();
  }

  public function simpanPengguna($data){
    $this->db->insert($this->nama_tb,$data);
  }

  public function get_by_kd($kd_dosen){
    $this->db->where($this->nama_pk,$kd_dosen);
    $this->db->from($this->nama_tb);
    $this->db->join('dosen','dosen.kd_dosen=user.kd_dosen');
    return $this->db->get()->row();
  }

  public function get_by_lv($level){
    $this->db->from($this->nama_tb);
    $this->db->join('dosen','dosen.kd_dosen=user.kd_dosen');
    $this->db->where('hak_akses',$level);
    return $this->db->get()->row();
  }

  public function updatePengguna($data,$kd_dosen){
    $this->db->where($this->nama_pk,$kd_dosen);
    $this->db->update($this->nama_tb,$data);
  }

  public function delete($kd_dosen){
    $this->db->where($this->nama_pk,$kd_dosen);
    $this->db->delete($this->nama_tb);
  }
}

?>
