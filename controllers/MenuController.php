<?php
include_once '../config/db.php';
include_once '../models/Menu.php';
class MenuController{
    private $menu;

    public function __construct($db) {
        $this->menu = new Menu($db);
    }
    public function listarMenu(){
        $menus = $this->menu->obtenerMenu();
        return $menus;
    }
    public function listarMenuCRUD(){
        $menus = $this->menu->obtenerMenuCRUD();
        return $menus;
    }
    public function registrarItemMenu($nombre,$descripcion,$precio,$idcategoria){
        return $this->menu->agregarItemMenu($nombre,$descripcion,$precio,$idcategoria);
    }
    public function editarItemMenu($idmenu,$nombre,$descripcion,$precio,$idcategoria){
        return $this->menu->actualizarItemMenu($idmenu,$nombre,$descripcion,$precio,$idcategoria);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $nombre= $_POST['nombre'];
        $descripcion= $_POST['descripcion'];
        $precio= $_POST['precio'];
        $idcategoria = $_POST['categoria'];

        $database = new Database();
        $db = $database->getConnection();
        $controller = new MenuController($db);
        if($controller->registrarItemMenu($nombre,$descripcion,$precio,$idcategoria)){
            header('Location: /restaurante/views/Menu.php');
            exit();
        }else{
            echo json_encode(['error' => 'No se pudo insertar el menu']);
        }
    }else if(isset($_POST['action']) && $_POST['action'] === 'updatemenu'){
        $idmenu = $_POST['idmenuu']; 
        $nombre= $_POST['nombreu'];
        $descripcion= $_POST['descripcionu'];
        $precio= $_POST['preciou'];
        $idcategoria = $_POST['categoriau'];

        $database = new Database();
        $db = $database->getConnection();
        $controller = new MenuController($db);
        if($controller->editarItemMenu($idmenu,$nombre,$descripcion,$precio,$idcategoria)){
            header('Location: /restaurante/views/Menu.php');
            exit();
        }else{
            echo json_encode(['error' => 'No se pudo actualizar el menu']);
        }
    }
}
?>