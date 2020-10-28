<?php
/**
 * Created by Etah_lib.php.
 * Date: 2016. 4. 14.
 * Time: 오후 3:08
 * To change this template use File | Settings | File Templates.
 */


class Etah_lib {

	protected $_ci;

	public function __construct()
	{
		$this->_ci =& get_instance();
	}

	/**
	 * 최근본 상품 쿠키에 담기
	 *
	 * @param $goods_code
	 */
	public function set_cookie_new_goods($goods_code)
	{
		$data = array();

		//최근 본 상품 쿠키 저장
		$cookie_search_goods = get_cookie('VIEWGOODS');
		if( ! empty($cookie_search_goods) ){
			$cookie_search_goods_arr = explode("|", $cookie_search_goods);
			array_unshift($cookie_search_goods_arr, $goods_code);

			//기존 저장된 상품코드 중복제거
			$cookie_search_goods_arr = array_unique($cookie_search_goods_arr);
			//12개만 쿠키에 담는다
			$i = 0;
			foreach($cookie_search_goods_arr as $cg) {
				if($i < 12) $data[] = $cg;
				$i++;

			}
			/*for($i=0; $i<count($cookie_search_goods_arr); $i++) {
				if($i < 6) $data[] = $cookie_search_goods_arr[$i];
			}*/
			$cookie_search_goods_str = implode('|', $data);

			delete_cookie('VIEWGOODS');
			set_cookie('VIEWGOODS', $cookie_search_goods_str, 0);
		}
		else{
			delete_cookie('VIEWGOODS');
			set_cookie('VIEWGOODS', $goods_code, 0);
		}
	}


	/**
	 * 저장된 쿠키에서 해당 상품 제거
	 *
	 * @param $goods_code
	 */
	public function delete_cookie_new_goods($goods_code)
	{
		$data = array();

		//최근 본 상품 쿠키 저장
		$cookie_search_goods = get_cookie('SEARCHGOODS');
		if( ! empty($cookie_search_goods) ){
			$cookie_search_goods_arr = explode("|", $cookie_search_goods);
			foreach($cookie_search_goods_arr as $cg) {
				if($cg != $goods_code) {
					$data[] = $cg;
				}
			}
			//기존 저장된 상품코드 중복제거
			$data = array_unique($data);
			$cookie_search_goods_str = implode('|', $data);

			delete_cookie('SEARCHGOODS');
			set_cookie('SEARCHGOODS', $cookie_search_goods_str, 0);
		}
	}

	/**
	 * 상단 카테고리 메뉴 데이타 구하기
	 *
	 * @return array|mixed
	 */
	public function get_category_menu()
	{
		$menu_js_cache_file = "./application/cache/menu_serialize.php";

		if( ! $cache_js = read_file($menu_js_cache_file)) {
			return self::_category_menu_arr();
		}
		else {
			//return self::_category_menu_arr();
			return unserialize($cache_js);
		}
	}

	/**
	 * 카테고리 캐쉬 데이타 파일 생성 모듈
	 *
	 * @return array
	 */
	private function _category_menu_arr()
	{
		$data = array();

		$this->_ci->load->model('menu_m');

		$arr_menu1_cd = array();
		$arr_menu2_cd = array();
		$arr_menu3_cd = array();
		$arr_menu1_nm = array();
		$arr_menu2_nm = array();
		$arr_menu3_nm = array();
		$arr_banner_nm = array();
		$arr_banner_img = array();
		$arr_banner_url = array();

		$rows = $this->_ci->menu_m->get_catemenu();
		$a = 0;

		foreach($rows as $row) {
			$arr_menu1_cd[$a] = $row['CATEGORY_DISP_CD'];
			$arr_menu1_nm[$a] = $row['CATEGORY_DISP_NM'];
			$arr_banner_nm[$a] = $row['CATE_BANNER_NAME'];
			$arr_banner_img[$a] = $row['CATE_BANNER_IMG'];
			$arr_banner_url[$a] = $row['CATE_BANNER_LINK'];

			$rows2 = $this->_ci->menu_m->get_menu($row['CATEGORY_DISP_CD']);
			$b = 0;
			foreach($rows2 as $row2) {
				$arr_menu2_cd[$a][$b] = $row2['CATEGORY_DISP_CD'];
				$arr_menu2_nm[$a][$b] = $row2['CATEGORY_DISP_NM'];

//				$rows3 = $this->_ci->menu_m->get_menu($row2['CATEGORY_DISP_CD']);
//				$c = 0;
//				foreach($rows3 as $row3) {
//					$arr_menu3_cd[$a][$b][$c] = $row3['CATEGORY_DISP_CD'];
//					$arr_menu3_nm[$a][$b][$c] = $row3['CATEGORY_DISP_NM'];
//
//					$c++;
//				}
				$b++;
			}
			$a++;
		}

		$data['category']['arr_menu1_cd'	] = $arr_menu1_cd;
		$data['category']['arr_menu2_cd'	] = $arr_menu2_cd;
//		$data['category']['arr_menu3_cd'	] = $arr_menu3_cd;
		$data['category']['arr_menu1_nm'	] = $arr_menu1_nm;
		$data['category']['arr_menu2_nm'	] = $arr_menu2_nm;
		$data['category']['arr_banner_nm'	] = $arr_banner_nm;
		$data['category']['arr_banner_img'	] = $arr_banner_img;
		$data['category']['arr_banner_url'	] = $arr_banner_url;
//		$data['category']['arr_menu3_nm'	] = $arr_menu3_nm;

//		var_dump($data['category']['arr_menu1_nm']);


		$w_data = serialize($data);
		write_file('./application/cache/menu_serialize.php', $w_data);
//var_dump(write_file('./application/cache/menu_serialize.php', $w_data));
//var_dump($w_data);
		return $data;
	}

	/**
	 * 카테고리 캐쉬 데이타 파일 생성 모듈
	 *
	 * @return array
	 */
	private function _category_menu_arr_2()
	{
		$data = array();

		$this->_ci->load->model('menu_m');

		$rows = $this->_ci->menu_m->get_cate_menu();

		$data['category'] = $rows;

//		var_dump($data);

		$w_data = serialize($data);
		write_file('./application/cache/menu_serialize.php', $w_data);

//var_dump($w_data);
		return $data;
	}
}