
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Akademik';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_pembayaran');

	}

	public function starter()
	{}


	public function index()
	{
		$this->starter();
        $ta_aktif       = $this->Model_global->getTahunAjaranAktif();
        $username  		= $this->session->userdata('username');
        $getdatauser 	= $this->Model_global->getDataUsername($username);
        $this->data['data_khs']           = $this->Model_global->krs_khs($getdatauser['nim'], $ta_aktif['kd_ta']);

        $this->data['detil_bayar']        = $this->Model_pembayaran->detil_bayar($getdatauser['nim'], $ta_aktif['kd_ta']);
        $this->data['totalbayar']        = $this->Model_pembayaran->totalbayar($getdatauser['nim'], $ta_aktif['kd_ta']);
        $this->data['sisa_bayar']        = $this->Model_pembayaran->sisa_bayar($getdatauser['nim'], $ta_aktif['kd_ta']);
        // tesx($this->data['detil_bayar'] );

		$this->render_template('index',$this->data);
	}





}

?>
