<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\LayoutResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\LayoutRequest;
use Illuminate\Http\Request;
use App\Models\Layout;

class LayoutController extends Controller {
    
    /**
     * Construct  
     */
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //return response()->json(['data' => 'disabled show all layouts', 'message' => 'error'], 403);
        try {
            $records = Layout::all();

            return response()->json(['data' => LayoutResource::collection($records), 'message' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'message' => 'error'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LayoutRequest $request) {
        //try {

            // We check same row and column
            if(Layout::where(['column' => (integer)$request->column, 'row' => (integer)$request->row])->first())
                return response()->json(['data' => 'has already same data', 'message' => 'error'], 400);

            // set array
            $spiral = array();

            // We set origin for column and row
            // Because we starting from 0 
            $firstRow = 0;
            $firstColumn = 0;

            // This is value of coordinates
            // this is variable our count
            $value = 0;

            // array starting 0
            $column = $request->column - 1;
            $row = $request->row - 1;

            //reason we use do-while is that the row and column take a minimum value of 1
            // One value must be generated
            do {
                /**
                 * We using 4 for 
                 * right, down, left, right (for loops)
                 */
                
                // Static Row, Dynamic Column
                // Starting first row
                for ($i = $firstColumn; $i <= $column; $i++) { 
                    $spiral[$firstRow][$i] = $value;
                    $value++;
                }
                $firstRow++;
                
                // Static Column, Dynamic Row
                // going down
                for ($j = $firstRow; $j <= $row; $j++) { 
                    $spiral[$j][$column] = $value;
                    $value++;
                }
                $column--;

                // Static row, Dynamic Column
                // bottom and center bottom
                for ($k = $column; $k >= $firstColumn; $k--) { 
                    $spiral[$row][$k] = $value;
                    $value++;
                }
                $row--;

                // Static column, dynamic row
                // going up
                for ($w = $row; $w >= $firstRow ; $w--) { 
                    $spiral[$w][$firstColumn] = $value;
                    $value++;
                }
                $firstColumn++;

            } while($firstRow <= $row && $firstColumn <= $column);

            /*for($i = 0; $i < count($spiral); $i++) {
                for($j = 0; $j < count($spiral[0]); $j++) {
                    echo ($spiral[$i][$j]." | ");
                }
                echo ("<br>");
            }*/

            // Write to db
            $layout = new Layout();
            $layout->row = $request->row;
            $layout->column = $request->column;
            $layout->values = json_encode($spiral, true);
            $layout->save();

            return response()->json(['data' => (new LayoutResource($layout)), 'message' => 'success'], 201);
        /*} catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'message' => 'error'], 400);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            $record = Layout::findOrFail($id);

            return response()->json(['data' => (new LayoutResource($record)), 'message' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'message' => 'error'], 400);
        }
    }

    /**
     * 
     * 
     */
    public function update(Request $request, $id) {
        return response()->json(['data' => 'disabled this method', 'message' => 'error'], 400);
    }

    /**
     * 
     * 
     * 
     */
    public function getValue(LayoutRequest $request, $id) {
        try {
            $record = Layout::findOrFail($id);

            // set 
            $column = $request->column;
            $row = $request->row;

            // Check
            if(is_numeric($row)
            && is_numeric($column)
            && $row > 0 
            && $column > 0) {
                // get values
                $result = json_decode($record->values, JSON_UNESCAPED_SLASHES);

                if(! isset($result[(integer)$row][(integer)$column]))          // check has value
                    return response()->json(['data' => 'not found value', 'message' => 'error'], 404);   
            } else
                return response()->json(['data' => 'wrong parameters', 'message' => 'error'], 400);

            return response()->json(['data' => (integer)$result[$row][$column], 'message' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => $e->getMessage(), 'message' => 'error'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $record = Layout::findOrFail($id);
            $record->delete();

            return response()->json(['data' => 'Successfuly deleted your record.', 'message' => 'success'], 200);
        } catch (\Exception $e) {
            
        }
    }
}
