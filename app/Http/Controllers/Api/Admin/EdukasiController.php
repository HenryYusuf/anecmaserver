<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EdukasiController extends BaseController
{
    public function dataEdukasi()
    {
        $results = Edukasi::orderBy('created_at', 'desc')->get();

        return $this->sendResponse($results, 'Edukasi retrieved successfully.');
    }

    public function insertEdukasi(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'judul' => 'required',
            'konten' => 'required',
            'thumbnail' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $uploadFileUrl = Cloudinary::upload($input['thumbnail']->getRealPath(), [
            'folder' => 'Edukasi/Thumbnail',
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'fill'
            ],
            'allowed_formats' => ['jpg', 'jpeg', 'png']
        ])->getSecurePath();

        $thumbnailPublicId = Cloudinary::getPublicId($uploadFileUrl);

        $user = Auth::user();

        $edukasi = Edukasi::create([
            'created_by' => $user->id,
            'judul' => $input['judul'],
            'konten' => $input['konten'],
            'thumbnail' => $uploadFileUrl,
            'thumbnail_public_id' => $thumbnailPublicId,
            'jenis' => $input['jenis'],
            'kategori' => $input['kategori'],
        ]);

        return $this->sendResponse($edukasi, 'Edukasi inserted successfully.');
    }

    public function showEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        return $this->sendResponse($edukasi, 'Edukasi retrieved successfully.');
    }

    public function updateEdukasi(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'judul' => 'required',
            'konten' => 'required',
            'thumbnail' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $edukasi = Edukasi::find($id);

        $uploadFileUrl = "";
        $thumbnailPublicId = "";

        if ($input['thumbnail'] !== $edukasi->thumbnail) {

            $publicId = $edukasi->thumbnail_public_id;

            $exists = Storage::disk('cloudinary')->fileExists($publicId);

            if ($exists) {
                Cloudinary::destroy($publicId);
            }

            $uploadFileUrl = Cloudinary::upload($input['thumbnail']->getRealPath(), [
                'folder' => 'Edukasi/Thumbnail',
                'transformation' => [
                    'width' => 400,
                    'height' => 400,
                    'crop' => 'fill'
                ],
                'allowed_formats' => ['jpg', 'jpeg', 'png']
            ])->getSecurePath();

            $thumbnailPublicId = Cloudinary::getPublicId($uploadFileUrl);
        } else {
            $uploadFileUrl = $input['thumbnail'];
            $thumbnailPublicId = $edukasi->thumbnail_public_id;
        }

        $edukasi->update([
            'judul' => $input['judul'],
            'konten' => $input['konten'],
            'thumbnail' => $uploadFileUrl,
            'thumbnail_public_id' => $thumbnailPublicId,
            'jenis' => $input['jenis'],
            'kategori' => $input['kategori'],
        ]);

        return $this->sendResponse($edukasi, 'Edukasi updated successfully.');
    }

    public function deleteEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        $publicId = $edukasi->thumbnail_public_id;

        $exists = Storage::disk('cloudinary')->fileExists($publicId);

        if ($exists) {
            Cloudinary::destroy($publicId);
        }

        $edukasi->delete();

        return $this->sendResponse($edukasi, 'Edukasi deleted successfully.');
    }
}
