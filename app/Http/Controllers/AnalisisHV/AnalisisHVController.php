<?php

namespace App\Http\Controllers\AnalisisHV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\balanceSheet;
use App\Models\IncomeStatement;
use App\Models\Periods;

class AnalisisHVController extends Controller
{
//=======================================================================================================
// ANALISIS PARA BALANCE GENERAL------------------------------------->>>>>
//=======================================================================================================
    public function balanceAnalize(Request $request, $companyId){

        $company = Company::where('id', $companyId)->first();// Compañia a la que se le hace el análisis

    //Obtener los balances de esa compañia para sacar los años en que esta tiene balances (solo 1 por cada periodo) 
        $companyYears = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->get()->unique('period_id');

        $years = array(); // para el id de los periodos de balances de la compañia
        foreach($companyYears as $cy){ array_push($years, $cy->period_id); }//se agragan los id al array
        $yearsCount = count($years);// cantidad de periodos registrados por la compañia (deben ser al menos 2)
        $desiredYears = 2;//Cant de periodos que se quiere analizar, por defecto son 2 años
        $type = $request->type;// Tipo de analisis: 1->Horizontal, 2->Vertical
        
        $periods1 = Periods::whereIn('id', $years)->orderBy('year','ASC')->get();//periodos solo de esa compañia, para el select del año 1
        unset($years[0]);//sacar el 1er elemento para que en el select del año 2 no salga el año 1
        $periods2 = Periods::whereIn('id', $years)->orderBy('year','ASC')->get();//periodos solo de esa compañia, quitando el primer elemento del año 1
        $periods3 = [];
        if( count($years) >=2){//hay almenos 2 valores en el array de periodos de la compañia, osea que tenga al menos 3 años registrados
            unset($years[1]);//sacar el 1er elemento para que en el select del año 3 no salgan los años 1 ni 2
            $periods3 = Periods::whereIn('id', $years)->orderBy('year','ASC')->get();//periodos solo de esa compañia, quitando el primer elemento del año 1
        }

        $yearHeader1 = "";// Cabecera del la tabla para el año 1
        $yearHeader2 = "";// Cabecera del la tabla para el año 2
        $yearHeader3 = "";// Cabecera del la tabla para el año 3
        $yearHeader4 = "";// Cabecera del la tabla para lo que se necesite
        $yearHeader5 = "";// Cabecera del la tabla para lo que se necesite

        $verticalResults = array(); // Para guardar los resultados a mandar a la vista
        $horizontalResults = array(); // Para guardar los resultados a mandar a la vista

        $error = 0;
        $msj = "";
//Comprobar que Año 1 < Año 2 & Año 2 < Año 3, además de que vayan de forma consecutiva----------------------------->
        if($request->type != 0){ //Ya se ha elegido el tipo de análisis
            $yearOneInt = 1;
            $yearTwoInt = 2;
            $yearThreeInt = 3;

            if ($request->yearOne != 0){ // Si mandamos un valor en el select del año
                $yearOneSelected = Periods::where('id', $request->yearOne)->first(); //buscamos ese año
                $yearOneInt = intval($yearOneSelected->year); // caonvertir a entero el año
            }
            if ($request->yearTwo != 0){
                $yearTwoSelected = Periods::where('id', $request->yearTwo)->first();
                $yearTwoInt = intval($yearTwoSelected->year);
            }
            if ($request->yearThree != 0){
                $yearThreeSelected = Periods::where('id', $request->yearThree)->first();
                $yearThreeInt = intval($yearThreeSelected->year);
            }

            if ($request->yearOne != 0 And $request->yearTwo != 0){
                if ($request->yearThree == 0){
                    if(($yearOneInt >= $yearTwoInt) Or ($yearOneInt < ($yearTwoInt - 1))){
                        $error = 1;
                        $msj = $msj."El Año 1 y Año 2 no son correctos.\nAño 1 y 2 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.balanceAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                }else{
                    if(($yearOneInt >= $yearTwoInt) Or ($yearOneInt < ($yearTwoInt - 1))){
                        $error = 1;
                        $msj = $msj."El Año 1 y Año 2 no son correctos.\nAño 1 y 2 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.balanceAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                    if(($yearTwoInt >= $yearThreeInt) Or ($yearTwoInt < ($yearThreeInt - 1))){
                        $error = 1;
                        $msj = $msj."El Año 2 y Año 3 no son correctos,\nAño 1, 2 y 3 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.balanceAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                    if(($yearOneInt >= $yearThreeInt) Or ($yearOneInt < ($yearThreeInt - 2))){
                        $error = 1;
                        $msj = $msj."El Año 1 y Año 3 no son correctos.\nAño 1, 2 y 3 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.balanceAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                }
            }

        }
        
        if($request->type == 1){ //ANALISIS HORIZONTAL--------------------------------------------------------------->>>>>>>>
            if($yearsCount >= 2){//hay al menos 2 periodos registrados para esta compañia

                //Necesitamos al menos 2 años para hacer el analisis, los obtenenmos de $request
                if ($request->yearOne != 0 And $request->yearTwo != 0){
                    //Balances del año 1 y 2 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                    $yearOne = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearOne)->get();
                    $yearTwo = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->where('period_id', $request->yearTwo)->get();
                    $yearHeader1 = $yearOne[0]->period->year;
                    $yearHeader2 = $yearTwo[0]->period->year;

                    if($request->yearThree != 0 And $yearsCount >= 3){// Si hay año 3 en el request Y la compañia SI tiene registrado un AÑO 3 o más
                        $yearThree = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->where('period_id', $request->yearThree)->get();
                        $desiredYears = 3;//Se desea analizar 3 años
                        $yearHeader3 = $yearThree[0]->period->year;
                        $yearHeader4 = $yearOne[0]->period->year.'-'.$yearTwo[0]->period->year;
                        $yearHeader5 = $yearTwo[0]->period->year.'-'.$yearThree[0]->period->year;
                    }

                    for ($i = 0; $i < $size = count($yearOne); $i++) {
                        if($request->yearThree != 0){// Si hay año 3 en el request
                            $absOneTwo = $yearTwo[$i]->data - $yearOne[$i]->data; // Variación absoluta entre año 1 y 2
                            $relOneTwo = ($absOneTwo/$yearOne[$i]->data) * 100; // Varicación relativa entre año 1 y 2
                            $absTwoThree = $yearThree[$i]->data - $yearTwo[$i]->data; // Variación absoluta entre año 2 y 3
                            $relTwoThree = ($absTwoThree/$yearTwo[$i]->data) * 100; // Varicación relativa entre año 2 y 3

                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "data3" => $yearThree[$i]->data,
                                "abs1" => $absOneTwo,
                                "rel1" => round($relOneTwo,2).' %',
                                "abs2" => $absTwoThree,
                                "rel2" => round($relTwoThree,2).' %',
                            ];
                            array_push($horizontalResults, $item);
                        }else{
                            $abs = $yearTwo[$i]->data - $yearOne[$i]->data; // Variación absoluta
                            $rel = ($abs/$yearOne[$i]->data) * 100; // Varicación relativa

                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "abs" => $abs,
                                "rel" => round($rel,2).' %',
                            ];
                            array_push($horizontalResults, $item);
                        }
                    }
                
                    $popLastElement = array_pop($horizontalResults);// quitamos el ultimo elemento ( TOTAL PASIVO + PATRIMONIO )

                    return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                }
                if(($request->yearOne == 0 And $request->yearTwo == 0) Or ($request->yearOne != 0 And $request->yearTwo == 0) Or ($request->yearOne != 0 And $request->yearThree != 0) Or ($request->yearOne == 0 And $request->yearTwo != 0 And $request->yearThree == 0)){
                    $error = 1;
                    $msj = $msj."\nDebe seleccionar por lo menos el Año 1 y Año 2 para Análisis Horizontal";
                    return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                }
            }else{
                $error = 1;
                $msj = $msj.'La compañia debe tener balances de al menos 2 periodos para poder realizar análisis horizontal';

                return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
            }
        }
        
        if ($request->type == 2) { //ANALISIS VERTICAL --------------------------------------------------------->>>>>>>
            if($yearsCount >= 1){//hay al menos 1 periodo registrado para esta compañia

                if ($request->yearOne != 0){
                    //Balances del año 1 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                    $yearOne = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearOne)->get();
                    
                    $totalYearOne = $yearOne[0]->data;// El 1er elemento es el valor del Activo
                    $desiredYears = 1;//Cant de periodos que se quiere analizar, por defecto son 2 años
                    $yearHeader1 = $yearOne[0]->period->year;

                    if ($request->yearTwo != 0){
                        //Balances del año 2 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                        $yearTwo = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearTwo)->get();
                        $totalYearTwo = $yearTwo[0]->data;// El 1er elemento es el valor del Activo
                        $desiredYears = 2;//Cant de periodos que se quiere analizar, por defecto son 2 años
                        $yearHeader2 = $yearTwo[0]->period->year;
                    }

                    if ($request->yearThree != 0){
                        //Balances del año 3 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                        $yearThree = balanceSheet::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearThree)->get();
                        $totalYearThree = $yearThree[0]->data;// El 1er elemento es el valor del Activo
                        $desiredYears = 3;//Cant de periodos que se quiere analizar, por defecto son 2 años
                        $yearHeader3 = $yearThree[0]->period->year;

                        if ($request->yearTwo == 0){
                            $error = 1;
                            $msj = $msj.'Debe seleccionar los Años en orden ( Año 1, Año 2, Año 3 )';
    
                            return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                        }
                    }

                    for ($i = 0; $i < $size = count($yearOne); $i++) {
                        //Cambiamos el denominador por el valor de Pasivo o Petrimonio cuando toque
                        if($yearOne[$i]->title == "PASIVO"){ $totalYearOne = $yearOne[$i]->data; }
                        if($yearOne[$i]->title == "PATRIMONIO"){ $totalYearOne = $yearOne[$i]->data; }

                        $v1 = ($yearOne[$i]->data / $totalYearOne) * 100;

                        if ($request->yearTwo != 0){
                            //Cambiamos el denominador por el valor de Pasivo o Petrimonio cuando toque
                            if($yearTwo[$i]->title == "PASIVO"){ $totalYearTwo = $yearTwo[$i]->data; }
                            if($yearTwo[$i]->title == "PATRIMONIO"){ $totalYearTwo = $yearTwo[$i]->data; }

                            $v2 = ($yearTwo[$i]->data / $totalYearTwo) * 100;
                        }

                        if ($request->yearThree != 0){
                            //Cambiamos el denominador por el valor de Pasivo o Petrimonio cuando toque
                            if($yearThree[$i]->title == "PASIVO"){ $totalYearThree = $yearThree[$i]->data; }
                            if($yearThree[$i]->title == "PATRIMONIO"){ $totalYearThree = $yearThree[$i]->data; }

                            $v3 = ($yearThree[$i]->data / $totalYearThree) * 100;
                        }

                        if($request->yearOne != 0 And $request->yearTwo != 0 And $request->yearThree != 0){
                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "data3" => $yearThree[$i]->data,
                                "v1" => round($v1,2).' %',
                                "v2" => round($v2,2).' %',
                                "v3" => round($v3,2).' %',
                            ];
                        }
                        elseif($request->yearOne != 0 And $request->yearTwo != 0){
                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "v1" => round($v1,2).' %',
                                "v2" => round($v2,2).' %',
                            ];
                        }
                        elseif($request->yearOne != 0){
                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "v1" => round($v1,2).' %',
                            ];
                        }
                        array_push($verticalResults, $item);
                    }
                }
                else{
                    $error = 1;
                    $msj = $msj.'Debe seleccionar por lo menos el Año 1 para poder realizar el Análisis Vertical';

                    if (($request->yearTwo == 0 And $request->yearThree != 0) Or ($request->yearTwo != 0 And $request->yearThree != 0)){
                        $msj = 'Debe seleccionar los Años en orden ( Año 1, Año 2, Año 3 )';
                    }
    
                    return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                }

                $popLastElement = array_pop($verticalResults);// quitamos el ultimo elemento ( TOTAL PASIVO + PATRIMONIO )

                return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
            }
            else{
                $error = 1;
                $msj = $msj.'La compañia debe tener balances de al menos 1 periodo para poder realizar análisis vertical';

                return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
            }
        }
        
        if($request->type == 0){
            $error = 1;
            $msj = $msj."\nDebe seleccionar un tipo de Análisis";
            return view('AnalisisHV.balanceAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
        }
    }

//=======================================================================================================
// ANALISIS PARA ESTADO DE RESULTADOS------------------------------------->>>>>
//=======================================================================================================
    public function incomeAnalize(Request $request, $companyId){

        $company = Company::where('id', $companyId)->first();// Compañia a la que se le hace el análisis

    //Obtener los balances de esa compañia para sacar los años en que esta tiene balances (solo 1 por cada periodo) 
        $companyYears = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->get()->unique('period_id');

        $years = array(); // para el id de los periodos de balances de la compañia
        foreach($companyYears as $cy){ array_push($years, $cy->period_id); }//se agragan los id al array
        $yearsCount = count($years);// cantidad de periodos registrados por la compañia (deben ser al menos 2)
        $desiredYears = 2;//Cant de periodos que se quiere analizar, por defecto son 2 años
        $type = $request->type;// Tipo de analisis: 1->Horizontal, 2->Vertical
        
        $periods1 = Periods::whereIn('id', $years)->orderBy('year','ASC')->get();//periodos solo de esa compañia, para el select del año 1
        unset($years[0]);//sacar el 1er elemento para que en el select del año 2 no salga el año 1
        $periods2 = Periods::whereIn('id', $years)->orderBy('year','ASC')->get();//periodos solo de esa compañia, quitando el primer elemento del año 1
        $periods3 = [];
        if( count($years) >=2){//hay almenos 2 valores en el array de periodos de la compañia, osea que tenga al menos 3 años registrados
            unset($years[1]);//sacar el 1er elemento para que en el select del año 3 no salgan los años 1 ni 2
            $periods3 = Periods::whereIn('id', $years)->orderBy('year','ASC')->get();//periodos solo de esa compañia, quitando el primer elemento del año 1
        }

        $yearHeader1 = "";// Cabecera del la tabla para el año 1
        $yearHeader2 = "";// Cabecera del la tabla para el año 2
        $yearHeader3 = "";// Cabecera del la tabla para el año 3
        $yearHeader4 = "";// Cabecera del la tabla para lo que se necesite
        $yearHeader5 = "";// Cabecera del la tabla para lo que se necesite

        $verticalResults = array(); // Para guardar los resultados a mandar a la vista
        $horizontalResults = array(); // Para guardar los resultados a mandar a la vista

        $error = 0;
        $msj = "";
//Comprobar que Año 1 < Año 2 & Año 2 < Año 3, además de que vayan de forma consecutiva----------------------------->
        if($request->type != 0){ //Ya se ha elegido el tipo de análisis
            $yearOneInt = 1;
            $yearTwoInt = 2;
            $yearThreeInt = 3;

            if ($request->yearOne != 0){ // Si mandamos un valor en el select del año
                $yearOneSelected = Periods::where('id', $request->yearOne)->first(); //buscamos ese año
                $yearOneInt = intval($yearOneSelected->year); // caonvertir a entero el año
            }
            if ($request->yearTwo != 0){
                $yearTwoSelected = Periods::where('id', $request->yearTwo)->first();
                $yearTwoInt = intval($yearTwoSelected->year);
            }
            if ($request->yearThree != 0){
                $yearThreeSelected = Periods::where('id', $request->yearThree)->first();
                $yearThreeInt = intval($yearThreeSelected->year);
            }

            if ($request->yearOne != 0 And $request->yearTwo != 0){
                if ($request->yearThree == 0){
                    if(($yearOneInt >= $yearTwoInt) Or ($yearOneInt < ($yearTwoInt - 1))){
                        $error = 1;
                        $msj = $msj."El Año 1 y Año 2 no son correctos.\nAño 1 y 2 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.incomeAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                }else{
                    if(($yearOneInt >= $yearTwoInt) Or ($yearOneInt < ($yearTwoInt - 1))){
                        $error = 1;
                        $msj = $msj."El Año 1 y Año 2 no son correctos.\nAño 1 y 2 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.incomeAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                    if(($yearTwoInt >= $yearThreeInt) Or ($yearTwoInt < ($yearThreeInt - 1))){
                        $error = 1;
                        $msj = $msj."El Año 2 y Año 3 no son correctos,\nAño 1, 2 y 3 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.incomeAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                    if(($yearOneInt >= $yearThreeInt) Or ($yearOneInt < ($yearThreeInt - 2))){
                        $error = 1;
                        $msj = $msj."El Año 1 y Año 3 no son correctos.\nAño 1, 2 y 3 deben ser CONSECUTIVOS";
                        return view('AnalisisHV.incomeAnalize', compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                    }
                }
            }

        }
        
        if($request->type == 1){ //ANALISIS HORIZONTAL--------------------------------------------------------------->>>>>>>>
            if($yearsCount >= 2){//hay al menos 2 periodos registrados para esta compañia

                //Necesitamos al menos 2 años para hacer el analisis, los obtenenmos de $request
                if ($request->yearOne != 0 And $request->yearTwo != 0){
                    //Balances del año 1 y 2 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                    $yearOne = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearOne)->get();
                    $yearTwo = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->where('period_id', $request->yearTwo)->get();
                    $yearHeader1 = $yearOne[0]->period->year;
                    $yearHeader2 = $yearTwo[0]->period->year;

                    if($request->yearThree != 0 And $yearsCount >= 3){// Si hay año 3 en el request Y la compañia SI tiene registrado un AÑO 3 o más
                        $yearThree = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->where('period_id', $request->yearThree)->get();
                        $desiredYears = 3;//Se desea analizar 3 años
                        $yearHeader3 = $yearThree[0]->period->year;
                        $yearHeader4 = $yearOne[0]->period->year.'-'.$yearTwo[0]->period->year;
                        $yearHeader5 = $yearTwo[0]->period->year.'-'.$yearThree[0]->period->year;
                    }

                    for ($i = 0; $i < $size = count($yearOne); $i++) {
                        if($request->yearThree != 0){// Si hay año 3 en el request
                            $absOneTwo = $yearTwo[$i]->data - $yearOne[$i]->data; // Variación absoluta entre año 1 y 2
                            $relOneTwo = ($absOneTwo/$yearOne[$i]->data) * 100; // Varicación relativa entre año 1 y 2
                            $absTwoThree = $yearThree[$i]->data - $yearTwo[$i]->data; // Variación absoluta entre año 2 y 3
                            $relTwoThree = ($absTwoThree/$yearTwo[$i]->data) * 100; // Varicación relativa entre año 2 y 3

                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "data3" => $yearThree[$i]->data,
                                "abs1" => $absOneTwo,
                                "rel1" => round($relOneTwo,2).' %',
                                "abs2" => $absTwoThree,
                                "rel2" => round($relTwoThree,2).' %',
                            ];
                        }else{
                            $abs = $yearTwo[$i]->data - $yearOne[$i]->data; // Variación absoluta
                            $rel = ($abs/$yearOne[$i]->data) * 100; // Varicación relativa

                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "abs" => $abs,
                                "rel" => round($rel,2).' %',
                            ];
                        }
                        if($item["title"] == "VENTAS NETAS" Or $item["title"] == "COSTO DE VENTAS" Or $item["title"] == "GASTOS" Or $item["title"] == "UTILIDAD ANTES DEL IMPUESTO"){
                            array_push($horizontalResults, $item);
                        } 
                    }
                
                    // $popLastElement = array_pop($horizontalResults);// quitamos el ultimo elemento ( TOTAL PASIVO + PATRIMONIO )

                    return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                }
                if(($request->yearOne == 0 And $request->yearTwo == 0) Or ($request->yearOne != 0 And $request->yearTwo == 0) Or ($request->yearOne != 0 And $request->yearThree != 0) Or ($request->yearOne == 0 And $request->yearTwo != 0 And $request->yearThree == 0) Or ($request->yearOne == 0 And $request->yearTwo != 0 And $request->yearThree != 0)){
                    $error = 1;
                    $msj = $msj."\nDebe seleccionar por lo menos el Año 1 y Año 2 para Análisis Horizontal";
                    return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                }
            }else{
                $error = 1;
                $msj = $msj.'La compañia debe tener balances de al menos 2 periodos para poder realizar análisis horizontal';

                return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
            }
        }
        
        if ($request->type == 2) { //ANALISIS VERTICAL --------------------------------------------------------->>>>>>>
            if($yearsCount >= 1){//hay al menos 1 periodo registrado para esta compañia

                if ($request->yearOne != 0){
                    //Balances del año 1 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                    $yearOne = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearOne)->get();
                    
                    $totalYearOne = $yearOne[0]->data;// El 1er elemento es el valor de VENTAS NETAS
                    $desiredYears = 1;//Cant de periodos que se quiere analizar, por defecto son 2 años
                    $yearHeader1 = $yearOne[0]->period->year;

                    if ($request->yearTwo != 0){
                        //Balances del año 2 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                        $yearTwo = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearTwo)->get();
                        $totalYearTwo = $yearTwo[0]->data;// El 1er elemento es el valor del VENTAS NETAS
                        $desiredYears = 2;//Cant de periodos que se quiere analizar, por defecto son 2 años
                        $yearHeader2 = $yearTwo[0]->period->year;
                    }

                    if ($request->yearThree != 0){
                        //Balances del año 3 de la compañia, exeptuando los que son separadores ( is_separator = 1 )
                        $yearThree = IncomeStatement::where('company_id', $company->id)->where('data','<>', 0)->where('period_id',$request->yearThree)->get();
                        $totalYearThree = $yearThree[0]->data;// El 1er elemento es el valor del VENTAS NETAS
                        $desiredYears = 3;//Cant de periodos que se quiere analizar, por defecto son 2 años
                        $yearHeader3 = $yearThree[0]->period->year;

                        if ($request->yearTwo == 0){
                            $error = 1;
                            $msj = $msj.'Debe seleccionar los Años en orden ( Año 1, Año 2, Año 3 )';
    
                            return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                        }
                    }

                    for ($i = 0; $i < $size = count($yearOne); $i++) {
                        $v1 = ($yearOne[$i]->data / $totalYearOne) * 100;

                        if ($request->yearTwo != 0){
                            $v2 = ($yearTwo[$i]->data / $totalYearTwo) * 100;
                        }

                        if ($request->yearThree != 0){
                            $v3 = ($yearThree[$i]->data / $totalYearThree) * 100;
                        }

                        if($request->yearOne != 0 And $request->yearTwo != 0 And $request->yearThree != 0){
                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "data3" => $yearThree[$i]->data,
                                "v1" => round($v1,2).' %',
                                "v2" => round($v2,2).' %',
                                "v3" => round($v3,2).' %',
                            ];
                        }
                        elseif($request->yearOne != 0 And $request->yearTwo != 0){
                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "data2" => $yearTwo[$i]->data,
                                "v1" => round($v1,2).' %',
                                "v2" => round($v2,2).' %',
                            ];
                        }
                        elseif($request->yearOne != 0){
                            $item = [ 
                                "title" => $yearOne[$i]->title,
                                "data1" => $yearOne[$i]->data,
                                "v1" => round($v1,2).' %',
                            ];
                        }
                        if($item["title"] == "VENTAS NETAS" Or $item["title"] == "COSTO DE VENTAS" Or $item["title"] == "GASTOS" Or $item["title"] == "UTILIDAD ANTES DEL IMPUESTO"){
                            array_push($verticalResults, $item);
                        } 
                    }
                }
                else{
                    $error = 1;
                    $msj = $msj.'Debe seleccionar por lo menos el Año 1 para poder realizar el Análisis Vertical';

                    if (($request->yearTwo == 0 And $request->yearThree != 0) Or ($request->yearTwo != 0 And $request->yearThree != 0)){
                        $msj = 'Debe seleccionar los Años en orden ( Año 1, Año 2, Año 3 )';
                    }
    
                    return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
                }

                // $popLastElement = array_pop($verticalResults);// quitamos el ultimo elemento ( TOTAL PASIVO + PATRIMONIO )

                return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults','verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
            }
            else{
                $error = 1;
                $msj = $msj.'La compañia debe tener balances de al menos 1 periodo para poder realizar análisis vertical';

                return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'verticalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
            }
        }
        
        if($request->type == 0){
            $error = 1;
            $msj = $msj."\nDebe seleccionar un tipo de Análisis";
            return view('AnalisisHV.incomeAnalize',compact('company', 'periods1', 'periods2','periods3', 'type', 'horizontalResults', 'yearHeader1','yearHeader2', 'yearHeader3','yearHeader4','yearHeader5','desiredYears','request','error','msj'));
        }
    }

    public function storePeriod(Request $request){
        $request->validate([
            'year'=>'required|numeric|unique:periods,year',
        ]);

        $y = new Periods;

        $y->year = e($request->year);

        $y->save();

        return back()->with('error','Periodo Agregado');
    }
}
