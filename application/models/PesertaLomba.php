<?php  

	defined('BASEPATH') OR exit('No direct script access allowed');

	class PesertaLomba extends CI_Model {

		public function getDataPesertaLomba() {

			$this->db->select("tb_peserta.id as id_nama_peserta, tb_peserta.tgl_daftar as tgl_daftar, tb_peserta.lomba as lomba, tb_peserta.nama as nama, daftar_lomba.nama_lomba as nama_lomba, daftar_lomba.id as id_lomba ");
			$this->db->from("tb_peserta");
			$this->db->join('daftar_lomba', 'daftar_lomba.id = tb_peserta.lomba', 'left');
			$this->db->order_by('tgl_daftar', 'desc');
			$query = $this->db->get();
			return $query->result();

		}

		public function getDaftarLomba() {

			$this->db->select("*");
			$this->db->from("daftar_lomba");
			$this->db->order_by('nama_lomba', 'ASC');
			$query = $this->db->get();
			return $query->result();

		}

		public function queryInsertData($data) {

			$this->db->insert("tb_peserta", $data);

		}

		public function queryDetailData($id) {

			$this->db->where("id", $id);
			$executeQuery = $this->db->get('tb_peserta');
			return $executeQuery->row();

		}

		public function queryUpdateData($data, $id) {

			$this->db->where("id", $id);
			$this->db->update("tb_peserta", $data);

		}

		public function queryDeleteData($id) {

			$this->db->where('id', $id);
			$this->db->delete("tb_peserta");

		}

	}

?>