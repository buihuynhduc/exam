<?php
    namespace Data;
    use \PDO;
    
	class PDOData {
		private $db = null; //Doi tuong PDO
		
		/**
		* Ham tao
		*/
		public function __construct() {
			
			    /* Ket noi CSDL */
				$this->db = new PDO("mysql:host=localhost;dbname=demo;", "root", "");
				$this->db->exec("set names 'utf8'");
			
		}
		
		
		/**
		* Ham huy
		*/
		public function __destruct() {
		    /** Dong ket noi */
			
				$this->db = null;
			
		}

        /**
		* Thuc hien truy van
		* $query: Cau lenh select
		* return: mang cac ban ghi, so trang
		*/
		public function doQuery($query) {
			$ret = array(); 
			
			
				$stmt = $this->db->query($query);  
				if ($stmt) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$ret[] = $row; 
					}
				} 
			
			
			return $ret;
		}
		
		/**
		* Thực hiện truy vấn theo câu lệnh chuẩn bị trước
		* $queryTmpl: Mẫu câu truy vấn
		* $paras: Mảng các tham số cho truy vấn
		* return: Mảng các bản ghi
		*/
		public function doPreparedQuery($queryTmpl, $paras) {
			$ret = array();
			
				$stmt = $this->db->prepare($queryTmpl);
				foreach ($paras as $k=>$v) $stmt->bindValue($k+1, $v);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$ret[] = $row; 
				}
			
			
			return $ret;
		}
		//truy vấn trả về 1 bản ghi	
		public function doPreparedQueryFetch($queryTmpl, $paras) {
			
				$stmt = $this->db->prepare($queryTmpl);
				foreach ($paras as $k=>$v) $stmt->bindValue($k+1, $v);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$ret = $row; 
				}
			
			return $ret;
		}
		/**
		* Thuc hien cap nhat
		* $sql: Cau lenh insert, update, delete, ...
		* return: So ban ghi duoc cap nhat
		*/
		public function doSql($sql) {
			$count = 0;
			
				$count = $this->db->exec($sql);
			
			return $count;
		}
		
		/**
		* Thực hiện cập nhật theo câu lệnh chuẩn bị trước
		* $queryTmpl: Mẫu câu cập nhật insert, update, delete, ...
		* $paras: Mảng các tham số cho câu lệnh cập nhật
		* return: Số bản ghi đã cập nhật
		*/
		public function doPrepareSql($queryTmpl, $paras) {
			
				$stmt = $this->db->prepare($queryTmpl);
				foreach ($paras as $k=>$v) $stmt->bindValue($k+1, $v);
				$stmt->execute();
			
		}		 
}