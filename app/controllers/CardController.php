<?php


require_once './app/setup.php';
require_once './app/resource/resource.php';
class CardController extends Controller
{
    private $__smarty;
    private $__CardModel;
    private $__UserModel;
    private $__ColumnModel;
    function __construct()
    {
        $this->__smarty = new Template();
        $this->__smarty->caching = false;
        $this->__CardModel = $this->model('CardModel');
        $this->__ColumnModel = $this->model('ColumnModel');
        $this->__UserModel = $this->model('UserModel');
    }
    public function getData()
    {
        $columnList = $this->__ColumnModel->getAllColumn();
        foreach ($columnList as &$column) {
            $cardList = $this->__CardModel->getCardByColumn($column['IDcolumn']);
            foreach ($cardList as &$card) {
                $userList = $this->__UserModel->getUserByCard($card['IDcard']);
                $card['userList'] = $userList;
            }
            $column['cardlist'] = $cardList;
        }
        echo json_encode($columnList);
    }
    public function setPosition()
    {
        $toColumn = $_POST["toColumn"];
        $idCard = $_POST["idCard"];
        $result = $this->__CardModel->setStateCard($toColumn, $idCard);
        if ($result == 1) {
            return "Erorr";
        }
    }
    public function addCard()
    {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $startdate = UTIL::convertDate($_POST["startdate"]);
        $duedate = UTIL::convertDate($_POST["duedate"]);
        $priority = $_POST["priority"];
        $idcol=$_POST["idcol"];
        $result=$this->__CardModel->addCard($title,$description,$startdate,$duedate,$priority,$idcol);
        if($result!=-1)
        {
            $cardList = $this->__CardModel->getCardByColumn($idcol);
            foreach ($cardList as &$card) {
                $userList = $this->__UserModel->getUserByCard($card['IDcard']);
                $card['userList'] = $userList;
            }
            echo json_encode($cardList);
        }
    }
    public function delete()
    {
        $idCard=$_POST["card"];
        $IDColumn= $this->__CardModel->getColIDCard($idCard);
        $this->__CardModel->deleteCard($idCard);
        $cardList = $this->__CardModel->getCardByColumn($IDColumn);
        foreach ($cardList as &$card) {
            $userList = $this->__UserModel->getUserByCard($card['IDcard']);
            $card['userList'] = $userList;
        }
        $response=array(
            "card"=>$cardList,
            "idcol"=>$IDColumn,
        );
        echo json_encode($response);
    }
}