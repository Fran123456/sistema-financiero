<?php

namespace App\Http\Controllers\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Catalog;
use App\Models\Account;
use App\Models\Periods;
use App\Models\IncomeStatementConf;
use App\Models\balanceSheetConf;
use App\Models\balanceSheet;
use App\Models\IncomeStatement;

class BalanceController extends Controller
{
    public function index($companyId){ //View all the busines rotation
       $company=Company::find($companyId);
       return view('balances.balances-menu',compact('company'));
    }

    public function IncomeStatementConf($companyId){
      $catalog=Catalog::where('company_id', $companyId)->where('status', true)->first();
      if($catalog!=null){
        $accounts=Account::where('catalog_id', $catalog->id)->get();
        if(count($accounts)>0){
          //content
          $company=Company::find($companyId);
          return view('balances.income-statement-conf', compact('company'));
          //content
        }else{
          return back()->with('error','Debe cargar cuentas contables al catalogo para configurar el estado de resultados');
        }
      }else{
        return back()->with('error','Debe existir un catalogo activo para poder configurar el estado de resultados');
      }
    }

    public function IncomeStatement($companyId){
      $catalog=Catalog::where('company_id', $companyId)->where('status', true)->first();

      if($catalog!=null){
          //validar si esta configurado
          $incomeConf=IncomeStatementConf::where('group', null)->get();
          if(count($incomeConf)>0){
              $company=Company::find($companyId);
              $periods = Periods::orderBy('year','ASC')->get();


              return view('balances.income-statement', compact('incomeConf', 'company','periods','catalog'));
          }else{
            return back()->with('error','No hay configuración existente para realizar el
            estado de resultados, por favor crear una configuración');
          }

      }else{
        return back()->with('error','Debe existir un catalogo activo para poder configurar el estado de resultados');
      }
    }

    public function deleteIncomeStatement($period, $company){
      IncomeStatement::where('period_id', $period)->where('company_id', $company)->delete();
      return back()->with('error','Se ha eliminado correctamente');
    }


    public function SaveIncomeStatement(Request $request){

      //validate
      if(IncomeStatement::where('company_id', $request->company_id)->where('period_id', $request->period_id)->first()!=null){
        return back()->with('error','Ya se ha cargado un estado de resultado para el periodo seleccionado');
      }

      $incomeConf=IncomeStatementConf::where('group', null)->get();
      $order=1;//1

      foreach ($incomeConf  as $key => $data){
        //para titulos
        IncomeStatement::create([
          'title'=> $data->title,
          'is_title'=>true,
          'is_total'=>false,
          'is_sub_total'=>false,
          'is_separator'=>false,
          'data'=>  $request['title-total'. $data->id],
          'order'=> $order,
          'company_id'=> $request->company_id,
          'period_id'=> $request->year,
        ]);
        $order++;//2

        IncomeStatement::separator($request->company_id, $request->year, $order);
        $order++;//3....

        foreach ($data->getIncomentStatementConfByCompany($request->company_id,$data->id, $request->catalog_id) as $key2 => $d){
          //echo $request['inp'.$data->id.'-'.$d->id] . '<br>';
          IncomeStatement::create([
            'title'=> $d->title,
            'is_title'=>false,
            'is_total'=>false,
            'is_sub_total'=>false,
            'is_separator'=>false,
            'data'=>  $request['inp'.$data->id.'-'.$d->id],
            'order'=> $order,
            'account_id'=> $request['val'.$data->id.'-'.$d->id],
            'catalog_id'=>$request->catalog_id,
            'company_id'=> $request->company_id,
            'period_id'=> $request->year,
          ]);
          $order++;
        }

          if ($data->id==2){
            IncomeStatement::create([
              'title'=> "UTILIDAD BRUTA",
              'is_title'=>false,
              'is_total'=>true,
              'is_sub_total'=>false,
              'is_separator'=>false,
              'data'=>  $request->utilidadBruta,
              'order'=> $order,
              'company_id'=> $request->company_id,
              'period_id'=> $request->year,
            ]);
            $order++;
          }
      }

      IncomeStatement::separator($request->company_id, $request->year, $order);
      $order++;//3....

      //fonales
      IncomeStatement::create([
        'title'=> "UTILIDAD ANTES DEL IMPUESTO",
        'is_title'=>false,
        'is_total'=>false,
        'is_sub_total'=>true,
        'is_separator'=>false,
        'data'=>  $request->antes,
        'order'=> $order,
        'company_id'=> $request->company_id,
        'period_id'=> $request->year,
      ]);
      $order++;

      IncomeStatement::create([
        'title'=> "IMPUESTO A LA UTILIDAD",
        'is_title'=>false,
        'is_total'=>false,
        'is_sub_total'=>true,
        'is_separator'=>false,
        'data'=>  $request->impuesto,
        'order'=> $order,
        'company_id'=> $request->company_id,
        'period_id'=> $request->year,
      ]);
      $order++;

      IncomeStatement::separator($request->company_id, $request->year, $order);
      $order++;//3....

      IncomeStatement::create([
        'title'=> "UTILIDAD NETA",
        'is_title'=>true,
        'is_total'=>true,
        'is_sub_total'=>false,
        'is_separator'=>false,
        'data'=>  $request->total,
        'order'=> $order,
        'company_id'=> $request->company_id,
        'period_id'=> $request->year,
      ]);
      $order++;

      return back()->with('error','Se ha guardado el balance correctamente');
    }


    ///BALANCE GENERAL
    public function balanceSheetConf($companyId){
      $catalog=Catalog::where('company_id', $companyId)->where('status', true)->first();
      if($catalog!=null){
        $accounts=Account::where('catalog_id', $catalog->id)->get();
        if(count($accounts)>0){
          //content
          $company=Company::find($companyId);
          return view('balances.balance-sheet-conf', compact('company'));
          //content
        }else{
          return back()->with('error','Debe cargar cuentas contables al catalogo para configurar el estado de resultados');
        }
      }else{
        return back()->with('error','Debe existir un catalogo activo para poder configurar el estado de resultados');
      }
    }

    public function balanceSheet($companyId){
        $catalog=Catalog::where('company_id', $companyId)->where('status', true)->first();
          if($catalog!=null){
              //validar si esta configurado
              $incomeConf=balanceSheetConf::where('group', null)->get();
              if(count($incomeConf)>0){
                  $company=Company::find($companyId);
                  $periods = Periods::orderBy('year','ASC')->get();
                  return view('balances.balance-sheet', compact('incomeConf', 'company','periods','catalog'));
              }else{
                return back()->with('error','No hay configuración existente para realizar el
                balance general, por favor crear una configuración');
              }

          }else{
            return back()->with('error','Debe existir un catalogo activo para poder configurar el balance general');
          }
    }


    public function SaveBalanceSheet(Request $request){
      //validate
      if(BalanceSheet::where('company_id', $request->company_id)->where('period_id', $request->period_id)->first()!=null){
        return back()->with('error','Ya se ha cargado un estado de resultado para el periodo seleccionado');
      }

      $incomeConf=BalanceSheetConf::where('group', null)->get();
      $order=1;//1

      foreach ($incomeConf  as $key => $data){
        //para titulos
        BalanceSheet::create([
          'title'=> $data->title,
          'is_title'=>true,
          'is_total'=>false,
          'is_sub_total'=>false,
          'is_separator'=>false,
          'data'=>  $request['title-total'. $data->id],
          'order'=> $order,
          'company_id'=> $request->company_id,
          'period_id'=> $request->year,
        ]);
        $order++;//2

        BalanceSheet::separator($request->company_id, $request->year, $order);
        $order++;//3....

        foreach ($data->getBalanceSheetByCompany($request->company_id,$data->id, $request->catalog_id) as $key2 => $d){
          //echo $request['inp'.$data->id.'-'.$d->id] . '<br>';
          BalanceSheet::create([
            'title'=> $d->title,
            'is_title'=>false,
            'is_total'=>false,
            'is_sub_total'=>false,
            'is_separator'=>false,
            'data'=>  $request['inp'.$data->id.'-'.$d->id],
            'order'=> $order,
            'account_id'=> $request['val'.$data->id.'-'.$d->id],
            'catalog_id'=>$request->catalog_id,
            'company_id'=> $request->company_id,
            'period_id'=> $request->year,
          ]);
          $order++;
        }

      }

      BalanceSheet::separator($request->company_id, $request->year, $order);
      $order++;//3....


      BalanceSheet::create([
        'title'=> "TOTAL PASIVO + PATRIMONIO",
        'is_title'=>false,
        'is_total'=>true,
        'is_sub_total'=>false,
        'is_separator'=>false,
        'data'=>  $request->pasivopatrimonio,
        'order'=> $order,
        'company_id'=> $request->company_id,
        'period_id'=> $request->year,
      ]);
      $order++;

      return back()->with('error','Se ha guardado el balance correctamente');
    }

    public function deleteBalanceSheet($period, $company){
      BalanceSheet::where('period_id', $period)->where('company_id', $company)->delete();
      return back()->with('error','Se ha eliminado correctamente');
    }

}
