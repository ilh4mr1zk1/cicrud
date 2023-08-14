<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->library('session');
		$this->load->model("PesertaLomba");

	}

	public function index () {

		$this->load->library('parser');

		$getData 		= $this->PesertaLomba->getDataPesertaLomba();
		$getDaftarLomba = $this->PesertaLomba->getDaftarLomba();

		$data = array(
	        'data_peserta' => $getData,
	        'daftar_lomba' => $getDaftarLomba
		);

		$this->parser->parse('home', $data);
	}

	public function insertData() {

		$bytesID = random_bytes(16);
		$id = bin2hex($bytesID);

		$Now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		$dateNow = $Now->format('Y-m-d H:i:s');
		$nama 	= $this->input->post('nama_lengkap');
		$lomba 	= $this->input->post('lomba');

		$dataInsert = array(
			'id' 			=> $id,
			'nama' 			=> $nama,
			'lomba' 		=> $lomba,
			'tgl_daftar' 	=> $dateNow
		);

		$this->PesertaLomba->queryInsertData($dataInsert);
		$this->session->set_flashdata('pesanih', 'Data Berhasil Ditambahkan!');
		redirect(base_url('Welcome'));

	}

	public function detailData($id) {

		$getId = $this->PesertaLomba->queryDetailData($id);
		
		$dataDetail = array(
			'data_update_peserta' => $getId
		);

		$this->load->view('Welcome', $dataDetail);
	
	}	

	public function updateData() {

		$id = $this->input->post('id_peserta');
		$nama = $this->input->post('nama_lengkap');
		$lomba = $this->input->post('lomba');

		$dataUpdate = array(
			'nama' => $nama,
			'lomba' => $lomba,
		);

		$this->PesertaLomba->queryUpdateData($dataUpdate, $id);
		$this->session->set_flashdata('pesanih', 'Data Berhasil Diupdate ');
		redirect(base_url('Welcome'));

	}

	public function deleteData($id) {

		$this->PesertaLomba->queryDeleteData($id);
		$this->session->set_flashdata('pesanih', 'Data Berhasil Dihapus!');
		redirect(base_url('Welcome'));

	}

	public function login () {
		$this->load->view('login');
	}	

}
