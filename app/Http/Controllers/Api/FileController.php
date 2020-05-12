<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class FileUploadController
 *
 * @package App\Http\Controllers\Api
 */
class FileController extends Controller
{
    /**
     * ファイルアップロード
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        ini_set('memory_limit', '512M');
        $file = $request->file('file');
        $userId = auth()->user()->id;
        $date = Carbon::now()->format('Y-m-d');
        //s3アップロード
        $path = Storage::disk('s3')->putFileAs("files/{$date}/{$userId}", $file, $file->getClientOriginalName(), 'public');

        return response()->json(['file_path' => Storage::disk('s3')->url($path)], 200, [], JSON_PRETTY_PRINT);
    }
}
