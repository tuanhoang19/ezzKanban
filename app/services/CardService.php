<?php

class CardService extends Controller
{
    private $__CardModel;
    private $__UserModel;

    public function __construct()
    {
        $this->__CardModel = $this->model('CardModel');
    }

    public function getAllData($columnService)
    {
        $columnList = $columnService->getAllColumn();
        foreach ($columnList as &$column) {
            $cardList = $this->getCardByColumn($column['IDcolumn']);
            foreach ($cardList as &$card) {
                $userList = $this->getUserByCard($card['IDcard']);
                $card['userList'] = $userList;
            }
            $column['cardlist'] = $cardList;
        }
        return $columnList;
    }

    public function setPositionCard($toColumn, $idCard)
    {
        return $this->__CardModel->setStateCard($toColumn, $idCard);
    }

    public function addCard($title, $description, $startdate, $duedate, $priority, $idcol)
    {
        $this->__CardModel->addCard($title, $description, $startdate, $duedate, $priority, $idcol);
    }

    public function getCardListByColumn($idCol)
    {
        $cardList = $this->getCardByColumn($idCol);
        foreach ($cardList as &$card) {
            $userList = $this->getUserByCard($card['IDcard']);
            $card['userList'] = $userList;
        }
        return $cardList;
    }

    public function getUserByCard($idCard)
    {
        $this->__UserModel = $this->model('UserModel');
        return $this->__UserModel->getUserByCard($idCard);
    }

    public function getCardByColumn($idCol)
    {
        return $this->__CardModel->getCardByColumn($idCol);
    }

    public function getColumnByIdCard($idCard)
    {
        return $this->__CardModel->getColIDCard($idCard);
    }

    public function deleteCard($idCard)
    {
        $this->__CardModel->deleteCard($idCard);
    }

    public function getDetailCard($idCard, $CommentService, $UserService, $ChecklistService)
    {
        $cardDetail = $this->getCardDetailWithUser($idCard);
        $commentList = $CommentService->getListCommentByCard($idCard, $UserService);
        $checklistList = $ChecklistService->getChecklistByCard($cardDetail['IDcard']);
        $cardDetail['commentList'] = $commentList;
        $cardDetail['checklistList'] = $checklistList;
        return $cardDetail;
    }

    public function getCardDetailWithUser($idCard)
    {
        $stop = "IDuser";
        $cardDetail = $this->__CardModel->getCardDetailWithUser($idCard);
        foreach ($cardDetail[0] as $key => $value) {
            if ($key == $stop) {
                break;
            }
            $cardDetailHandled[$key] = $value;
        }
        $cardDetailHandled['userList'] = $cardDetail;
        return $cardDetailHandled;
    }

    public function setPriorityCard($id, $state)
    {
        return $this->__CardModel->setPriorityCard($id, $state);
    }

    public function setStatusCard($id, $state)
    {
        return $this->__CardModel->setStatusCard($id, $state);
    }

    public function setTitleCard($id, $title)
    {
        return $this->__CardModel->setTitleCard($id, $title);
    }

    public function setDescriptionCard($id, $title)
    {
        return $this->__CardModel->setDescription($id, $title);
    }

    public function setStartdateCard($id, $startdate)
    {
        $startdate = substr($startdate, 0, 19);
        return $this->__CardModel->setStartdateCard($id, $startdate);
    }

    public function setDuedateCard($id, $duedate)
    {
        $duedate = substr($duedate, 0, 19);
        return $this->__CardModel->setDuedateCard($id, $duedate);
    }

    public function getUserNotinCard($idCard)
    {
        $this->__UserModel = $this->model('UserModel');
        return $this->__UserModel->getUserNotinCard($idCard);
    }

    public function addUserCard($idUser, $idCard)
    {
        return $this->__CardModel->addUserCard($idUser, $idCard);
    }

    public function delUserCard($idUser, $idCard)
    {
        return $this->__CardModel->delUserCard($idUser, $idCard);
    }
}
