<?php

use model\Event as Event;
use interfaces\ICrud as ICrud;

class EventDAO extends SingletonDAO implements ICrud
{
	private $table = "events";
	private $list = array();
	private static $instance();
	private $pdo;

	public function __construct()
	{
		$this->pdo = new Connection();
	}


	public function create($value)
	{
		try
		{
			$sql = "INSERT INTO $this->table (category, title)  VALUES (:category, :title)";

			$connection = Connection::connect(); // crea la coneccion a la bbdd
			$statement = $connection->prepare($sql);

			$category = $value->getCategoryEvent();
			$title = $value->getTitleEvent();

			$statement->bindParam(":category" , $category);
			$statement->bindParam(":title" , $title);

			$statement->execute();

			return $connection->lastInsertId();
		}
		catch(\PDOException $e)
		{
			throw $e;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	public function read($id)
	{
		try {

			$sql = "SELECT * FROM $this->table WHERE id_event = $id";

			$pdo = new Connection(); // <- en vez de esta y
			$connection = $pdo->connect(); // esta linea se puede poner $connection = Connection::connect();
			$statement = $connection->prepare($sql);

			$statement->execute();

			$dataSet[] = $statement->fetch(\PDO::FETCH_ASSOC);

			// como siempre va a traer un solo objeto pongo dataSet[0] ya que estoy parado en el primer lugar
			if($dataSet[0])
			{
				$this->mapMethod($dataSet);
			}

			if(!empty($this->list[0]))
			{
				return $this->list[0];
			}

			return false;

		}
		catch (\PDOException $e)
		{
			echo $e->getMessage();
			die();
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
			die();
		}

	}


	public function readAll()
	{
		try
		{
			$sql = "SELECT * FROM $this->table";

			$connection = Connection::connect();
			$statement = $connection->prepare($sql);

			$statement->execute();

			$dataSet = $statement->fetchAll(\PDO::FETCH_ASSOC);

			$this->mapMethod($dataSet);

			if(!empty($this->list))
			{
				return $this->list;
			}

			return null;
		}
		catch(\PDOException $e)
		{
			echo $e->getMessage();
			die();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			die();
		}
	}

	public function update($value)
	{
		try
		{
			$sql = "UPDATE $this->table SET category = :category AND title = :title WHERE id_artist = :id ";

			$connection = Connection::connect();
			$statement = $connection->prepare($sql);

			$category = $value->getCategoryEvent();
			$title = $value->getTitleEvent();
			$id = $value->getIdEvent();

			$statement->bindParam(":category",$category);
			$statement->bindParam(":title",$title);
			$statement->bindParam(":id",$id);

			$statement->execute();
		}
		catch(\PDOException $e)
		{
			echo $e->getMessage();
			die();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			die();
		}
	}

	public function delete($id)
	{
		try
		{
			$sql = "DELETE FROM $this->table WHERE id_event = :id "; // si es un string poner \" $id \";

			$connection = Connection::connect();
			$statement = $connection->prepare($sql);

			$statement->bindParam(":id", $id);

			$statement->execute();

		}catch(\PDOException $e)
		{
			echo $e->getMessage();
			die();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			die();
		}
	}


	// dataSet: conjunto de datos
	public function mapMethod($dataSet)
	{
		$dataSet = is_array($dataSet) ? $dataSet : false;

		if($dataSet)
		{
			$this->list = array_map(function ($p)
			{
				$u = new Event(
					$p['category'],
					$p['title']);
					$u->setIdEvent($p['id_event']);

					return $u;

				}, $dataSet); // end of array_map
			}
		}


	}