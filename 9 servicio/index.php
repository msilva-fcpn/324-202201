<?php
include "Conexion.php";
$pdo = new Conexion();

if ($_SERVER["REQUEST_METHOD"]=="GET")
{
	if (isset($_GET["id"]))
	{
		$sql = $pdo->prepare("select * from alumno where id=:id");
		$sql->bindValue(':id',$_GET["id"]);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 existen datos");
		echo json_encode($sql->fetchAll());
		exit;
	}
	else
	{
		$sql = $pdo->prepare("select * from alumno");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 existen datos");
		echo json_encode($sql->fetchAll());
		exit;
	}
	header("HTTP/1.1 400 Requerimiento inexistente");
}
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
	$s="insert into alumno(id,nombrecompleto,coddepto,promedio)";
	$s.=" values (:id,:nombrecompleto,:coddepto,:promedio)";
	$sql = $pdo->prepare($s);
	$sql->bindValue(':id',$_GET["id"]);
	$sql->bindValue(':nombrecompleto',$_GET["nombrecompleto"]);
	$sql->bindValue(':coddepto',$_GET["coddepto"]);
	$sql->bindValue(':promedio',$_GET["promedio"]);
	$sql->execute();
	$state=$pdo->lastInsertId();
	if ($state)
	{
		header("HTTP/1.1 200 insercion correcta");
		echo json_encode($state);
		exit;
	}
}
if ($_SERVER["REQUEST_METHOD"]=="DELETE")
{
	$sql = $pdo->prepare("delete from alumno where id=:id");
	$sql->bindValue(':id',$_GET["id"]);
	$sql->execute();
	header("HTTP/1.1 200 borrado");
	exit;
}
?>