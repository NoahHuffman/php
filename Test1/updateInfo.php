<!-- @author Noah Huffman
@class CPSC 3220
@date 02/13/2023
@assignment Test 1 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 
    $file2 = fopen("petInfo.txt", "r+") or die("Unable to open file!");   
    $file1 = fopen("newPetInfo.txt", "r+") or die("Unable to open file!");   
    
    $pet_name=$_POST['pet_name'];
    $pet_id=$_POST['pet_id'];
    $pet_weight=$_POST['pet_weight'];
    $birth_date=$_POST['birth_date'];

    //VALIDATION
    //TODO: Pet_ID, Pet_Weight
    $format = "/^(((0[13578]|1[02])\/(0[1-9]|[12]\d|3[01])\/((19|[2-9]\d)\d{2}))|((0[13456789]|1[012])\/(0[1-9]|[12]\d|30)\/((19|[2-9]\d)\d{2}))|(02\/(0[1-9]|1\d|2[0-8])\/((19|[2-9]\d)\d{2}))|(02\/29\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/";

    //Pet_ID Validation
    $arr=array();
    $chars = str_split($pet_id);

    foreach ($chars as $char) {
        array_push($arr, $char);  
    }

    $restofcode = true;
    if (strlen($pet_name) > 20){
        echo "Pet Name Length Exceeds 20 Characters <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }else if ((preg_match("/[0-9]+/", $pet_name)) == 1){
        echo "Pet Name Must Contain Only Alphabetical Characters <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }else if ((preg_match("/[\'^£$%&*()}{@#~?><.,|=`_+¬-]/", $pet_name)) == 1){
        echo "Pet Name Must Contain Only Alphabetical Characters <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }else if (strlen($pet_weight) > 7 || $pet_weight <= 0){
        echo "Invalid Pet Weight <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }else if(is_numeric($pet_weight) == 0){
        echo "Invalid Pet Weight <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }else if ((preg_match($format,$birth_date)) == false) {
        echo "Invalid Birth Date <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }else if (strlen($pet_id) != 7){
        echo "Invalid Pet ID <br>";
        echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
        $restofcode = false;
    }

if($restofcode==true){


    for($i=0;$i<4;$i++){
        //FIRST FOUR
        if((preg_match("/[\'^£$%&*()}{@#~?><.,|=`_+¬-]/", $arr[$i]))==1 || 
            (preg_match("/[0-9]+/", $arr[$i])) == 1 || (ctype_upper($arr[$i]))){
                echo "Invalid Pet ID <br>";
                echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
            }
    }
    for($i=4;$i<count($arr);$i++){
        //LAST THREE
        if((preg_match("/[\'^£$%&*()}{@#~?><.,|=`_+¬-]/", $arr[$i]))==1 || 
            (is_numeric($arr[$i])) == 0){
                echo "Invalid Pet ID <br>";
                echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
            }
    }

    

    $file1txt = 'newPetInfo.txt';
    $size = filesize($file1txt);

        $arr = array();

        file_put_contents($file1txt, ($pet_name . " " . $pet_id . " " . $pet_weight . " " . $birth_date).PHP_EOL, FILE_APPEND | LOCK_EX);

        while(!feof($file1)){
            $line = fgets($file1);
            array_push($arr, $line);
        }
        sort($arr);
        // print_r($arr);

        for($i=0;$i<count($arr);$i++){
            fwrite($file2, ($arr[$i]));
        }

        fclose($file2);
        fclose($file1);

        echo '<table border 1px>';
        echo '<tr>';
        echo '<th>' . "Name" . '</th>' . '   ';
        echo '<th>' . "ID" . '</th>' . '   ';
        echo '<th>' . "Weight" . '</th>' . '   ';
        echo '<th>' . "DOB" . '</th>' . '   ';
        echo '</tr>';

        for($i=0;$i<count($arr);$i++){
            $arr1 = explode(" ", $arr[$i]);
            if(!empty($arr[$i])){
            echo '<tr>';
            echo '<td>' . $arr1[0] . '</td>';
            echo '<td>' . $arr1[1] . '</td>';
            echo '<td>' . $arr1[2] . '</td>';
            echo '<td>' . $arr1[3] . '</td>';
            echo '</tr>';
            }
        }
        echo '</table>';
        echo "<a href=\"javascript:history.go(-1)\">HOME</a>";
}
?>

</body>
</html>