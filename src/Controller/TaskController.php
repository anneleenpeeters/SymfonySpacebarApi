<?php


namespace App\Controller;

use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    //DB Params
    private $host = 'localhost';
    private $db_name = 'city';
    private $username = 'root';
    private $password = 'mysql';
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
    }


    /**
     * @Route("/api/taken", methods={"GET"})
     * @return JsonResponse
     */
    public function getTaken()
    {
        $query = 'SELECT * FROM taak';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return new JsonResponse($rows);
    }
    // URL: http://localhost:8000/api/taken



    /**
     * @param $id
     * @return JsonResponse
     * @Route("/api/taak/{slugID}", methods={"GET"})
     */
    public function getTaak($slugID)
    {
        $query = "SELECT * FROM taak WHERE taa_id = $slugID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new JsonResponse($row);
    }
    // URL: http://localhost:8000/api/taak/1


    /**
     * @Route("/api/taken" , methods={"POST"})
     */
    public function postTaak()
    {
        //GET raw posted data
        $data = json_decode(file_get_contents('php://input'));

        $query = "INSERT INTO taak SET taa_datum = '$data->taa_datum', taa_omschr = '$data->taa_omschr'";
        $stmt = $this->conn->prepare($query);

        //Clean submit data
        $data->taa_omschr = htmlspecialchars(strip_tags($data->taa_omschr));

        //Execute query
        if($stmt->execute()) {
            echo json_encode(
                array('message' => 'Taak aangemaakt')
            );
        } else {
            echo json_encode(
                array('message' => 'Taak NIET aangemaakt')
            );
        }
    }
    // URL: http://localhost:8000/api/taken
    // Headers: Content-Type : application/json
    // Body: raw
    //{
    //    "taa_datum": "2020-03-19",
    //    "taa_omschr": "post post post"
    //}


    /**
     * @param $slugID
     * @return JsonResponse
     * @Route("/api/taak/{slugID}", methods={"PUT"})
     */
    public function putTaak($slugID){
        //GET raw posted data
        $data = json_decode(file_get_contents('php://input'));

        $query = "UPDATE taak SET taa_datum = '$data->taa_datum', taa_omschr = '$data->taa_omschr' WHERE taa_id = $slugID";
        $stmt = $this->conn->prepare($query);

        //Clean submit data
        $data->taa_omschr = htmlspecialchars(strip_tags($data->taa_omschr));
        $data->taa_datum = htmlspecialchars(strip_tags($data->taa_datum));

        //Execute query
        if($stmt->execute()) {
            echo json_encode(
                array('message' => 'Taak aangepast')
            );
        } else {
            echo json_encode(
                array('message' => 'Taak NIET aangepast')
            );
        }
    }
    // URL: http://localhost:8000/api/taak/1
    // Headers: Content-Type : application/json
    // Body: raw
    //{
    //    "taa_datum": "2020-03-19",
    //    "taa_omschr": "put put put"
    //}


    /**
     * @param $slugID
     * @Route("api/taak/{slugID}", methods={"DELETE"})
     */
    public function deleteTaak($slugID) {
        $query = "DELETE FROM taak WHERE taa_id = $slugID";
        $stmt = $this->conn->prepare($query);
        if($stmt->execute()) {
            echo json_encode(
                array('message' => 'Taak verwijderd')
            );
        } else {
            echo json_encode(
                array('message' => 'Taak NIET verwijderd')
            );
        }
    }
    // URL: http://localhost:8000/api/taak/1

}




