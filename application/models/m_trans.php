<?php
if (!defined('BASEPATH')) 
     exit('No direct script access allowed'); 
 
class m_trans extends CI_Model { 
 
 // insert data ke database    // 
   function tambah() { 
         $kode = $this->input->post('kd_harga'); 
         $tgl_trans = date('Y-m-d',strtotime($this->input->post('tanggal'))); 
         $nomor = $this->input->post('numb'); 
		 $buy = $this->input->post('select2');
         $price = $this->input->post('select'); 
        
         
         $data = array(
                         'id_trans' => NULL, 
                         'kode_harga' => $kode,
                         'tanggal'    => $tgl_trans, 
                         'nomor'      => $nomor,
            			 'beli'		  => $buy,
                         'harga'      => $price, 
                       );
        $alpa = "Z-0001";
        $hasil =   $this->db->where('kd_barang', $alpa)
                            ->get('tbl_stok');
        foreach ($hasil->result() as $key) 
        {
             $old = $key->beli;
        } 
         $current = $old - $price;
         $data2 = array(
                          'beli' => $current,  
                        );

         $this->db->where('kd_barang', $alpa)
                  ->update('tbl_stok',$data2);

         $this->db->insert('tbl_trans', $data); 
     }
	 
   // mengambil semua data dari database // 
     function ambil($limit, $offset) { 
          $ambil = $this->db->get('tbl_trans', $limit, $offset); 
         if ($ambil->num_rows() > 0) { 
             foreach ($ambil->result() as $data) { 
                 $hasil[] = $data; 
             } 
             return $hasil; 
         } 
     } 
//Pagination//
    function hitung() {
        $this->db->order_by('id_trans', 'ASC');
        return $this->db->count_all("tbl_trans");
    }

 function batas($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by('id_trans', 'ASC');
        $query = $this->db->get("tbl_trans");
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
 // mengambil data sesuai id_jenis    // 
   /**  function edit($a) { 
         $d = $this->db->get_where('tbl_trans', array('id_trans' => $a))->row(); 
         return $d; 
     } **/
 // menghapus salah satu data    // 
     function hapus($a) { 
        $alpa = "Z-0001";
        $hasil = $this->db->where('id_trans', $a)
                          ->get('tbl_trans');
        foreach ($hasil->result() as $key ) 
        {
            $old = $key->harga;    
        }

        $hasil2 = $this->db->where('kd_barang', $alpa)
                           ->get('tbl_stok');
        
        foreach ($hasil2->result() as $key2) 
        {
            $old2 = $key2->beli;
        }

        $current = $old2 + $old; 
        $data2 = array( 
                        'beli' => $current ,
                      );
        $this->db->where('kd_barang', $alpa)
                  ->update('tbl_stok',$data2);
        $this->db->where('id_trans', $a)
                 ->delete('tbl_trans'); 
        return;

     } 
function tampil(){
$keyword = $this->session->userdata('keyword');
        $this->db->from('tbl_trans');        
                
        $this->db->like('tanggal', $keyword);  
        
        return $this->db->count_all_results();
 }


function caridata($limit, $offset) {
$keyword = $this->session->userdata('keyword');
$this->db->like('tanggal', $keyword);  
$query = $this->db->get ('tbl_trans');
$this->db->limit($limit, $offset);
return $query->result();
if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        } 


}



} 