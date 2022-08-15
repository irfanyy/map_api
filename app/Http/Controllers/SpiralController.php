<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpiralController extends Controller {

    public function test($row, $column) {
        
        $spiral = [];

        $firstRow = 0;
        $firstColumn = 0;

        $flag = 0;

        $column = $column - 1;
        $row = $row - 1;

        do {
            
            // Static Row, Dynamic Column
            // Starting first row
            for ($i = $firstColumn; $i <= $column; $i++) { 
                $spiral[$firstRow][$i] = $flag;
                $flag++;
            }
            $firstRow++;
            
            // Static Column, Dynamic Row
            // We
            for ($j = $firstRow; $j <= $row; $j++) { 
                $spiral[$j][$column] = $flag;
                $flag++;
            }
            $column--;

            for ($k = $column; $k >= $firstColumn; $k--) { 
                $spiral[$row][$k] = $flag;
                $flag++;
            }
            $row--;

            for ($w = $row; $w >= $firstRow ; $w--) { 
                $spiral[$w][$firstColumn] = $flag;
                $flag++;
            }
            $firstColumn++;

        } while($firstRow <= $row && $firstColumn <= $column);
        
        //return ($spiral);

        for($i = 0; $i < count($spiral); $i++) {
            for($j = 0; $j < count($spiral[0]); $j++) {
                echo ($spiral[$i][$j]." | ");
            }
            echo ("<br>");
        }
        return;
    }

}
