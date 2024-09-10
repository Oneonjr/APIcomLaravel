<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
          
    }

    public function index(Request $request) //Read
    {       
        /**ADD FILTRO */
        //addPaginação

        $query = Series::query();

        if ($request->has('nome')) {
            $query->where('nome',$request->nome);
        }

        return $query->paginate(3);
    }

    public function store(SeriesFormRequest $request) //Read
    {
        return response()
        ->json($this->seriesRepository->add($request),201);
    }

    public function show(int $series) //Create
    {
        // $series = Series::whereId($series)->first(); //esta forma vai retorna um html com o erro 404

        $seriesModel = Series::with('seasons.episodes')->find($series);

        if($seriesModel == null){
            return response()->json(['message'=>'series not found'],404);
        }

        return $seriesModel;
    }

    public function update(Series $series, SeriesFormRequest $request) //Update
    {
        // $series->fill($request->all()); //Metodo menos efetido de inserir.
        // $series->save();
    
        Series::where('id', $series)->update($request->all());

        return $series;
    
    }

    public function destroy(int $series, Authenticatable $user) //Delete
    {   
        // dd($request->user()); //Utilizando o request.
        dd($user->tokenCan('series:delete'));
        Series::destroy($series);
        return response()->noContent();
    }
}
