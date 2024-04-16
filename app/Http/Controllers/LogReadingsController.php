<?php

namespace App\Http\Controllers;

use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogReadingsController extends Controller
{
    public function create(Request $request, string $key)
    {
        if ($key !== env('SECURE_KEY')) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }


        $data = json_decode($request->getContent());
        if(config('readings.log')) {
            Log::log('info', 'Received request', ['data' => $data]);
        }
        $insert = [];
        if(!is_array($data) || !count($data)) {
            return response()->json(['success' => false, 'message'=> 'No data' ]);
        }

        foreach($data as $d) {
            $fullSource = data_get($d, 'ID', '');
            $id = $this->getIdFromSourceId($fullSource);
            $fieldSource = $this->mapField($id);
            $insert[data_get(config('readings.mappings'), $fieldSource, 'source')] =  data_get($d, 'Value', 0);
        }

        $insert['source_id'] = $this->getSourceIp($fullSource);

        if (config('readings.log')) {
             Log::info('Inserting', ['data' => $insert, 'mappings' => config('readings.mappings'), 'source' => $fieldSource]);
        }

        $created = Reading::create($insert);

        return response()->json(['success' => true, 'created' => $created->toArray()]);
    }

    private function mapField(mixed $data_get): string
    {
        foreach(config('readings.mappings') as $key => $value) {
            if(str_contains($data_get, $key)) {
                return $key;
            }
        }
        return 'source';
    }

    private function getIdFromSourceId(string $sourceId): string
    {
        return Str::afterLast($sourceId, ';i=');
    }

    private function getSourceIp(string $id): string
    {
        return Str::between($id, '://', '/');
    }
}
