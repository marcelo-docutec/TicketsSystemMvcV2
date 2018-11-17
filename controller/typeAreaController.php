<?php

namespace controller;

use model\TypeArea as TypeArea;
use dao\TypeAreaDAO as TypeAreaDAO;
use controller\Controller as Controller;
use interfaces\IAlmr as IAlmr;

class TypeAreaController extends Controller implements IAlmr
{
    private $controllerDao;

    public function __construct () {
        parent::__construct();
        $this->controllerDao = TypeAreaDAO::getInstance();
    }

    public function index () {
        $this->list();
    }

    public function add ($data = []) {
        //create -> La llave es el campo en la base de dato y el valor es el valor a guardar en la base de dato
        $this->controllerDao->create([
          "_description" => $data["description"]
        ]);

        $this->redirect("/typeArea/");

        return;
    }

    public function list () {
		if ( ! $this->isLogged()) {
			$this->redirect('/default/login');
		}
		else {
			$items = $this->controllerDao->readAll();
			$this->render("viewTypeArea/typesAreas",[
				'items' => $items
			]);
		}
    }

    public function remove($data = []) {
		$searchedItem = $this->controllerDao->delete($data['id']);
		$this->redirect("/typeArea/");
	}

	public function viewEdit ($id) {
		$searchedItem = $this->controllerDao->read($id);
		$this->render('viewTypeArea/updateTypeArea',[
			'searchedItem' => $searchedItem
		]);
	}

  public function modify($data = [])
	{
		if ( ! $this->isMethod("POST")) $this->redirect("/default/");
		if (empty($data)) $this->redirect("/default/");
		$item = new TypeArea(
			$data["id"],
			$data["description"]
		);
		try
		{
			$this->controllerDao->update($item);
		}
		catch(\PDOException $e)
		{
			echo $e->getMessage();
		}
		catch(\Exception $e){
			echo $e->getMessage();
		}

		$this->redirect('/typeArea/');

	}

} // <----- end CLASS
