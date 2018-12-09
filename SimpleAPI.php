<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.12.2018
 * Time: 23:19
 */
use \RedBeanPHP\R as R;

class SimpleAPI
{

    public function __construct(){


        if ( !R::testConnection() )
        {
            R::setup('mysql:host=127.0.0.1;dbname=beacons','root', '' );
//            exit ('Нет соединения с базой данных');
        }
//        else echo "DONE<br>";
    }

    public function getNote(int $id){
        $note = R::getRow('select * from `notes` WHERE id = ?', array($id));
//        var_dump($note);
        print(json_encode($note));
    }


    public function getNotes(){
        $count = 0;
        $notes = R::getAll('select * from notes');
        foreach ( $notes as &$note) {
            $beacons_notes = R::getAll('SELECT * FROM beacons_notes WHERE beacons_notes.note_id = ?', array($note['id']));
//            var_dump($beacons_notes);
            foreach ($beacons_notes as $beacons_note) {
//                echo "BEACONS_NOTE: ".$beacons_note['beacon_id'];
//                var_dump($beacons_note);
                $count++;
                $note[] = R::getRow('select * from `beacons` WHERE id = ?', array($beacons_note["beacon_id"]));
//                echo "<br>";
//                var_dump($note['beacons']);
            }
        }
        unset($note);
//        echo "$count<br>";
        print(json_encode($notes));
    }

    public function getNotesForBeacon($beacon){

        $notes_id = R::getAll('SELECT * FROM beacons_notes WHERE beacons_notes.beacon_id = ?', array($beacon));
//        var_dump($notes_id);

        foreach ($notes_id as $item) {
            $notes[] = R::getRow('select * from `notes` WHERE id = ?', array($item["note_id"]));
        }
//        echo "<br>NOTES:<br>";
        print(json_encode($notes));
    }

    public function getBeacons(){
        $beacons = R::getAll('select * from beacons');
        print(json_encode($beacons));
    }

    public function addNote(){
        $note = $_POST['note'];
        R::exec('INSERT INTO `notes`(`id`, `name`, `text`, `color`) VALUES (?,?,?,?)', array());
//        var_dump($_POST);
    }
    public function deleteNote($id){
        echo "START";
        if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
            echo "DELETE";
        }
    }

    public function editNote($id){
       echo "PUT done";
        if($_SERVER['REQUEST_METHOD'] == 'PUT') {
            echo $_REQUEST["jso"];
            $putdata = file_get_contents('php://input');
//            $exploded = explode('&', $putdata);

//            foreach($exploded as $pair) {
//                $item = explode('=', $pair);
//                if(count($item) == 2) {
//                    $_PUT[urldecode($item[0])] = urldecode($item[1]);
//                }
//            }
        }
    }
}