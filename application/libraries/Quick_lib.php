<?php
/**
 * Created by Parameter.php.
 * Date: 2016. 4. 29.
 * Time: 오후 3:01
 * To change this template use File | Settings | File Templates.
 */


class Quick_lib {

	protected $_ci;

	public function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->load->model('quick_m');
	}

	/**
	 * Quick메뉴 데이타 가져오기
	 *
	 * @return array
	 */
	public function get_quick_goods()
	{
		$result = array();
		$result['new_goods'] = self::get_quick_view();
		$result['wish_goods'] = self::get_wish_goods();
		$result['cart_goods'] = self::get_cart_goods();
//var_dump($result);
		return $result;
	}

	/**
	 * 퀵 레이아웃 데이타 구하기
	 *
	 * @return array
	 */
	public function get_quick_layer($page = 1)
	{
		$result = array();

		$result['cart'		] = $this->_ci->quick_m->get_cart_goods($page);
		$result['cart_cnt'	] = $this->_ci->quick_m->get_cart_goods_count();
		$result['cart_page'	] = 1;

		$result['wish'		] = $this->_ci->quick_m->get_wish_goods($page);
		$result['wish_cnt'	] = $this->_ci->quick_m->get_wish_goods_count();
		$result['wish_page'	] = 1;

		$result['view'		] = $this->_ci->quick_m->get_view_goods($page);
		$result['view_cnt'	] = $this->_ci->quick_m->get_view_goods_count();
		$result['view_page'	] = 1;

		
//		VAR_DUMP($result['view_cnt']);

		return $result;

	}

	/**
	 * 퀵 레이아웃 데이타 구하기
	 *
	 * @return array
	 */
	public function get_quick_wish($page = 1)
	{
		$result = array();
		
		$result = $this->_ci->quick_m->get_wish_goods($page);
				
		return $result;

	}

	/**
	 * 퀵 레이아웃 데이타 구하기
	 *
	 * @return array
	 */
	public function get_quick_cart($page = 1)
	{
		$result = array();
		
		$result = $this->_ci->quick_m->get_cart_goods($page);

		return $result;

	}

	/**
	 * 퀵 레이아웃 데이타 구하기
	 *
	 * @return array
	 */
	public function get_quick_view($page = 1)
	{
		$result = array();
		
		$result = $this->_ci->quick_m->get_view_goods($page);

//		var_dump($result);
				
		return $result;

	}



}