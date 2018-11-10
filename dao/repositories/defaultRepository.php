<?php
namespace dao\repositories;

use dao\Connection as Connection;
use helpers\Collection as Collection;
use helpers\ConverterCase as ConverterCase;
use model\test\Model as Model;
use dao\DefaultDAO as DefaultDAO;

/**
 *
 */

 // TODO: Hacer inster para Many to Many :'v
class DefaultRepository
{

  private $modelMap;
  private $className;
  private $pdo;
  private $tableName;

  public function __construct ($className) {

    $this->className = $className;

    $exploded = explode("\\", $className);
    $tableName = array_pop($exploded);
    $tableName = ConverterCase::toSnakeCase($tableName);
    $tableName = ConverterCase::toPlural($tableName);
    $this->tableName = $tableName;

    $this->pdo = new Connection();
  }

  public function setModelMap ($modelMap) {
    $this->modelMap = $modelMap;
    return $this;
  }

  public function getModelMap () {
    return $this->modelMap;
  }

  public function findOneBy ($columns, $option = "AND") {
    foreach ($columns as $column => $value) {
      if ( ! $this->modelMap->hasField($column)) return false;
    }


    //query
    $sql = "SELECT * FROM $this->tableName WHERE ";
    $where = "";
    end($columns);
    $lastIndex = key($columns);

    foreach ($columns as $column => $value) {
      if ( $lastIndex == $column ) {
        $where .= " $column = '$value' ";
      } else {
        $where .= "$column = '$value' $option";
      }
    }

    $sql .= $where;

    $connection = $this->pdo->connect();
    $statement = $connection->prepare($sql);

    $statement->execute();
    //print_r($sql);
    //print_r($statement->errorInfo());

    $result = $statement->fetch(\PDO::FETCH_ASSOC);

    if ( ! $result) return false;

    $entity = new $this->className();

    foreach ($this->modelMap->fieldsModel as $fieldModel) {
      //clave foranea
      $getter = $fieldModel->getter;
      if ( $entity->$getter() instanceof Model::class) {
        $defaultDAO = new DefaultDAO();
        $repository
      }

      $setter = $fieldModel->setter;
      $field = $fieldModel->field;

      $entity->$setter($result[$field]);
    }

    return $entity;
  }

  public function findBy ($columns, $option = "AND") {
    foreach ($columns as $column => $value) {
      if ( ! $this->modelMap->hasField($column)) return false;
    }

    //query
    //query
    $sql = "SELECT * FROM $this->tableName WHERE ";
    $where = "";
    end($columns);
    $lastIndex = key($columns);

    foreach ($columns as $column => $value) {
      if ( $lastIndex == $column ) {
        $where .= " $column = '$value' ";
      } else {
        $where .= "$column = '$value' $option";
      }
    }

    $sql .= $where;

    $connection = $this->pdo->connect();
    $statement = $connection->prepare($sql);

    $statement->execute();

    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if ( ! $result) return false;

    $entityCollection = new Collection();

    foreach ($result as $row) {

      $entity = new $this->className;

      foreach ($this->modelMap->fieldsModel as $fieldModel) {
        $setter = $fieldModel->setter;
        $field = $fieldModel->field;
        $entity->$setter($row[$field]);
      }

      $entityCollection[] = $entity;
    }

    return $entityCollection;

  }

  //Create
  public function create ($entity) {

    $fields = $this->getOrderFields();
    $values = $this->getValuesFields($entity);

    $sql = "INSERT INTO $this->tableName $fields VALUES $values";
    $connection = $this->pdo->connect();
    $statement = $connection->prepare($sql);

    $statement->execute();
    print_r($statement->errorInfo());

    return $connection->lastInsertId();
  }

  private function getOrderFields () {
    $str = "(";
    foreach ($this->modelMap->fieldsModel as $fieldModel) {
      $str .= $fieldModel->field.",";
    }
    $str = substr($str,0, -1).")";

    return $str;
  }

  private function getValuesFields ($entity) {
    $str = "(";
    foreach ($this->modelMap->fieldsModel as $fieldModel) {
      $getter = $fieldModel->getter;
      $str .= "'".$entity->$getter()."',";
    }
    $str = substr($str,0, -1).")";

    return $str;
  }

}
