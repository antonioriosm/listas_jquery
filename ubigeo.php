<?php 

class UbiGeo
{
	public function __construct()
	{
		mysql_connect('localhost', 'usuario', 'clave');
		mysql_select_db('test');
	}

	public function cargarDepartamentos()
	{
		$sql = "SELECT id, desdep descri FROM departamentos";
		$this->listarOptions($sql);

	}
	public function cargarProvincias($coddep)
	{
		$sql = "SELECT id, despro descri FROM provincias
				WHERE departamento_id = $coddep";
		$this->listarOptions($sql);
	}
	public function cargarDistritos($codpro)
	{
		$sql = "SELECT id, desdist descri FROM distritos
				WHERE provincia_id = $codpro";
		$this->listarOptions($sql);
	}
	public function cargarCentros($coddis)
	{
		$sql = "SELECT ce.id, CONCAT(descat, ' ', descen) descri 
				FROM centros ce
				INNER JOIN categorias ca
				ON ce.categoria_id = ca.id
				WHERE distrito_id = $coddis";
		$this->listarOptions($sql);
	}

	private function listarOptions($sql)
	{
		$rs = mysql_query($sql);
		while($reg = mysql_fetch_assoc($rs)){
			echo "<option value='{$reg['id']}'>".utf8_encode($reg['descri'])."</option>";
		}
	}
}

$obUbigeo = new UbiGeo();

switch ($_GET['accion']) {
	case 'carga_dpto':
		$obUbigeo->cargarDepartamentos();
		break;
	case 'carga_prov':
		$obUbigeo->cargarProvincias($_GET['cd']);
		break;
	case 'carga_dist':
		$obUbigeo->cargarDistritos($_GET['cp']);
		break;
	case 'carga_cent':
		$obUbigeo->cargarCentros($_GET['cd']);
		break;

}
?>