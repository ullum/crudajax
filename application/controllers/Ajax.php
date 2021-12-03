<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ajax_model');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('ajax_view');
    }

    function getdata()
    {
        $datasiswa  =   $this->ajax_model->ambildata('siswa')->result();

        echo json_encode($datasiswa);
    }

    function tambahdata()
    {
        $nama   =   $this->input->post('nama');
        $kota   =   $this->input->post('kota');

        if ($nama == '') {
            $result['pesan'] = "Nama harus diisi";
        } elseif ($kota == '') {
            $result['kota'] = "Kota harus diisi";
        } else {
            $result['pesan'] = "";

            $data = array(
                'nama' => $nama,
                'kota' => $kota
            );

            $this->ajax_model->tambahdata($data, 'siswa');
        }

        echo json_encode($result);
    }

    function ambilNim()
    {
        $nim    =   $this->input->post('nim');
        $where  =   array('nim' => $nim);
        $datasiswa  =   $this->ajax_model->ambilNim('siswa', $where)->result();

        echo json_encode($datasiswa);
    }

    // Fungsi Edit Data
    function editdata()
    {
        $nim = $this->input->post('nim');
        $nama = $this->input->post('nama');
        $kota = $this->input->post('kota');


        if ($nama == '') {
            $result['pesan'] = "Nama harus diisi";
        } elseif ($kota == '') {
            $result['pesan'] = "Kota harus diisi";
        } else {
            $result['pesan'] = "";

            $where = array('nim' => $nim);

            $data = array(
                'nim' => $nim,
                'nama' => $nama,
                'kota' => $kota
            );
            $this->ajax_model->editdata($where, $data, 'siswa');
        }
        echo json_encode($result);
    }
}
