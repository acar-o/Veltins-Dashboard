<?php
//Get Gender by firstname
//https://github.com/tuqqu/gender-detector

include "./gd/src/GenderDetector.php";
include "./gd/src/Gender.php";
include "./gd/src/Country.php";
include "./gd/src/File/Format.php";
include "./gd/src/File/Reader.php";


// public $server = "localhost";
// public $user = "veltins_us5634";
// public $pass = "Jtr10s9^"; 

class Connect
{
  public $server = "localhost";
  public $user = "root";
  public $pass = "mysql"; 
  public $db;
  public $connection;
  public $result;
  public $sql =
  "SELECT 
    t.created_at as created_at, 
    t.firstname, 
    t.lastname, 
    t.city, 
    t.zip, 
    t.birthday, 
    a.timestamp_finished as feldersDatum, 
    (
        SELECT SUM(adventscalendar.isFinished) 
        FROM adventscalendar 
        WHERE adventscalendar.isFinished = '1') as gesamtGerubbelteFelder 
    FROM adventscalendar a 
    JOIN timestamp_winner t 
    ON t.uuid = a.userid 
    WHERE a.isFinished = '1'
    ORDER BY t.created_at ASC";


  function getData($_db)
  {
    $this->db = $_db;
    $this->connection = mysqli_connect($this->server, $this->user, $this->pass, $this->db);
    $this->result = mysqli_query($this->connection, $this->sql);
    if (mysqli_num_rows($this->result) > 0) {
      while ($row = mysqli_fetch_assoc($this->result)) {
        $data[] = $row;
      }
    
    }
    if ($data !== null) {
      $gender = new GenderDetector\GenderDetector();
      $names = [];
      $m = 0;
      $f = 0;


      for ($i = 0; $i < count($data); $i++) {
        if ($data[$i + 1]["firstname"] !== $data[$i]["firstname"] && $data[$i]["firstname"] !== null) {
          array_push($names, $gender->detect($data[$i]["firstname"], GenderDetector\Country::GERMANY));
        }
      }
      for ($i = 0; $i < count($names); $i++) {
        if ($names[$i] === 'female') {
          $f++;
        } else {
          $m++;
        }
      }
      $names = ['female' => $f, 'male' => $m];
      array_push($data, $names);
      return $data;
      $this->connection->close();
    }
  }
}
