<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadImageController extends BaseController
{
    public function uploadSingleImage(Request $request)
    {
        $validator = Validator::make($request, [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $uploadFileUrl = cloudinary()->upload($request->file('file')->getRealPath(), [
            'folder' => 'Edukasi',
            'allowed_formats' => ['jpg', 'jpeg', 'png']
        ])->getSecurePath();

        return $this->sendResponse($uploadFileUrl, 'File uploaded successfully.');
    }
}
