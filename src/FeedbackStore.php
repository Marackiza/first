<?php

namespace tatiana\first;
class FeedbackStore {
    function getFeedbackById(int $a){
        $temp=null;
        $link=new \SQLite3('db.sqlite');
        $result=$link->query("SELECT * FROM feedback");
        if($result!=false){
            for($array_data=[];$row=$result->fetchArray();$array_data[]=$row);
            while ($row = $result->fetchArray()){
                if($row['id']===$a){
                    $temp= $row['id'] . " " . $row['message']. " " .$row['date_post'];
                }
            }
        }
        else {
            return 'No records';
        }
        if($temp!=null){
            return $temp;
        }
        else{
            return "Message with id=$a does not exist";
        }
    }
    function returnFeedBack(){
        $link=new \SQLite3('db.sqlite');
        $feedback_page=3; //on page
        $result=$link->query("SELECT COUNT(*) as count FROM feedback");
        for($array_data=[];$row=$result->fetchArray();$array_data[]=$row);
        foreach ($array_data as $key => $value) {
            foreach ($value as $key1 => $value1){
                if($key1 === "count"){
                    $result=$value1;
                }
            }
        }
        if($result!=0) {
            $number_page = ceil($result / $feedback_page);
            for ($i = 1; $i <= $number_page; $i++) {
                echo '<a href="http://localhost:8080/?page=' . $i . '">' . $i . "</a>\n";
                echo " ";
            }
            if (isset($_GET['page']) && ($_GET['page'] >= 1) && ($_GET['page'] <= $number_page)) {
                $offset = ($_GET['page'] - 1) * $feedback_page;
                $result = $link->query("SELECT * FROM feedback ORDER BY date_post LIMIT $feedback_page OFFSET $offset");
                echo "<br/>";
                while ($row = $result->fetchArray()){
                    echo $row['id'] . " " . $row['message']. " " .$row['date_post'];
                    echo "<br/>";
                }
            }
            else {
                return "<br/>Page with №={$_GET['page']} - does not exist";
            }
        }
        else{
            return "No record";
        }
    }
}