<?php
define("ROOT_DIR",dirname(__FILE__)."/");
class FSExcel{
	public $creator;
	public $last_modify_by;
	public $title;
	public $subject;
	public $description;
	public $keyword;
	public $category; 
	public $active_sheet_index;
	public $obj_php_excel;
	public $font_name;
	public $font_size;
	public $active_sheet_title;
	public $out_put_xls;
	public $out_put_xlsx;
	
	function __construct()
	{
		set_include_path(get_include_path().PATH_SEPARATOR.ROOT_DIR.'libraries/excel/PHPExcel/Classes/'.PATH_SEPARATOR.ROOT_DIR.'libraries/excel/PHPExcel/Classes/PHPExcel/');
//		echo "===".get_include_path().PATH_SEPARATOR.ROOT_DIR.'libraries/excel/PHPExcel/Classes/'.PATH_SEPARATOR.ROOT_DIR.'libraries/excel/PHPExcel/Classes/PHPExcel/'."++++";
//		die;
//		set_include_path(PATH_BASE.'libraries'.DS.'excel'.DS.'PHPExcel'.DS);
		include PATH_BASE.'libraries'.DS.'excel'.DS.'PHPExcel'.DS.'Classes'.DS.'PHPExcel.php';
		$this->creator = 'FinalStyle';
		$this->last_modify_by = 'Stephen Viet';
		$this->last_modify_by = 'Stephen Viet';
		$this->subject = 'Sample Excel';
		$this->description = 'Sample Description';
		$this->description = 'Sample Keyword';
		$this->category = 'Sample Category';
		$this->active_sheet_index = 0;
		$this->font_name = "Arial";
		$this->font_size = 10;
		$this->active_sheet_title = "Order";
		$time = time();
		$this->out_put_xls = 'export/excel/don-hang.xls';
		$this->out_put_xlsx = 'export/excel/don-hang.xlsx';
		$this->obj_php_excel = new PHPExcel();
	}
	
	function set_params($params){
		foreach ($params as $key=>$val) {
			$this->$key = $val;
		}
		return $this;	
	}
	
	function apply_params(){
		$this->obj_php_excel->getProperties()->setCreator($this->creator);
		$this->obj_php_excel->getProperties()->setLastModifiedBy($this->last_modify_by);
		$this->obj_php_excel->getProperties()->setTitle($this->title);
		$this->obj_php_excel->getProperties()->setSubject($this->subject);
		$this->obj_php_excel->getProperties()->setDescription($this->description);
		$this->obj_php_excel->getProperties()->setKeywords($this->keyword);
		$this->obj_php_excel->getProperties()->setCategory($this->category);
		$this->obj_php_excel->setActiveSheetIndex($this->active_sheet_index);
		$this->obj_php_excel->getActiveSheet()->getDefaultStyle()->getFont()->setName($this->font_name);
		$this->obj_php_excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize($this->font_size);
		$this->obj_php_excel->getActiveSheet()->setTitle($this->active_sheet_title);
	}
	
	function write_files(){
		$this->apply_params();
		include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
		$objWriter = PHPExcel_IOFactory::createWriter($this->obj_php_excel, 'Excel2007');
//		$objWriter->save($this->out_put_xlsx);
		// $objWriter = PHPExcel_IOFactory::createWriter($this->obj_php_excel, 'Excel5');
		$objWriter->save($this->out_put_xls);
		return array(
			'xls'=>$this->out_put_xls,
//			'xlsx'=>$this->out_put_xlsx,
		);
	}
}

function FSExcel()
{
	return new FSExcel();
}

?>