<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
          
    }

    public function index() //Read
    {
        return Series::all();
    }

    public function store(SeriesFormRequest $request) //Read
    {
        return response()
        ->json($this->seriesRepository->add($request),201);
    }

    public function show(int $series) //Create
    {
        $series = Series::whereId($series)->first();

        return $series;
    }

    public function update(Series $series, SeriesFormRequest $request) //Update
    {
        $series->fill($request->all());
        $series->save();
    
        return $series;
    
    }

    public function destroy(int $series) //Delete
    {
        Series::destroy($series);
        return response()->noContent();
    }
}
