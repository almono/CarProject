<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CarModel;
use App\CarSubModel;
use App\Make;

class PageController extends Controller
{
    public function index()
    {
        $car_makes = Make::get();

        return view('welcome', compact('car_makes'));
    }

    public function getModels(Request $request)
    {

        $make_id = $request->get('car_model');

        if($make_id != '0')
        {
            $car_models = CarModel::where('make_id',$make_id)->get();
            return $car_models;
        }
        else {
            return false;
        }
    }

    public function getSubModels(Request $request)
    {

        $model_id = $request->get('car_submodel');
        $model = CarModel::find($model_id);

        if($model_id != '0')
        {
            $car_submodels = $model->submodels()->get();
            return $car_submodels;
        }
        else {
            return false;
        }
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('csv_file');

        // File Details
        $filename = $file->getClientOriginalName();

        $location = 'uploads';

        // Upload file
        $file->move($location,$filename);

        // Import CSV to Database
        $filepath = public_path($location."/".$filename);

        // Reading file
        $file = fopen($filepath,"r");

        $importData_arr = array();
        $i = 0;

        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);

            for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
            }
            $i++;

            $make = Make::where('make_name',$filedata[0])->first();
            $model = CarModel::where('model_name',$filedata[1])->first();
            if(!is_null($filedata[2]))
            {
                $submodel = CarSubModel::where('submodel_name',$filedata[2])->first();
            }

            if (is_null($make))
            {
                $new_make = new Make;
                $new_make->make_name = $filedata[0];
                $new_make->save();

                $ex_make = $new_make->id;
            }
            else {
                $ex_make = $make->id;
            }
            if (is_null($model))
            {
                $new_model = new CarModel;
                $new_model->model_name = $filedata[1];
                $new_model->make_id = $ex_make;
                $new_model->save();

                $ex_model = $new_model;
            }
            else {
                $ex_model = $model;
            }
            if ((!isset($submodel) || is_null($submodel)) && !is_null($filedata[2]))
            {
                $new_submodel = new CarSubModel;
                $new_submodel->submodel_name = $filedata[2];
                $new_submodel->save();

                $ex_submodel = $new_submodel;
            }
            else {
                $ex_submodel = $submodel;
            }

            if(!is_null($filedata[1]) && !is_null($filedata[2]))
            {
                $ex_model->submodels()->sync($ex_submodel);
            }


        }

        fclose($file);
        return back();

    }
}
