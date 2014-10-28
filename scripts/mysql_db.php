<?php

class mysql_db extends mysqli {

	public function query_all($sql,$data=array()) {

		if (!is_string($sql) || !is_array($data)) throw new RuntimeException('Argumentos inválidos para query_all()');
		if(count($data)!=substr_count($sql,'?')) throw new RuntimeException('La cantidad de incógnitas no es igual a la cantidad de elementos en el arreglo');

		// Verificar y cambiar las incógnitas por los valores del arreglo de datos.
		if (count($data)>0) {
			$i=0;
			$real_sql = '';
			$chunks = explode('?',$sql);
			foreach($data as $key => $value){
				if (is_null($value)) {
					$real_sql .= $chunks[$i++].'NULL';
				} else {
					$real_sql .= $chunks[$i++].'\''.$this->real_escape_string($value).'\'';
				}
			}
			if (isset($chunks[$i])) $real_sql .= $chunks[$i];
		} else {
			$real_sql = $sql;
		}

		// Ejecutar la sentencia
		$pre = $this->query($real_sql);

		// Retornar un valor true para las consultas que no regresan resultados y un arreglo para las que si.
		if (is_bool($pre)) {
			return $pre;
		} else {
			$retval = array();
			for ($i=0;$i<$pre->num_rows;$i++) {
				foreach($pre->fetch_assoc() as $key => $value) {
					//$retval[$i][utf8_encode($key)] = utf8_encode($value);
					$retval[$i][$key] = $value;
				}
			}
			return $retval;
		}
	}
}

?>
