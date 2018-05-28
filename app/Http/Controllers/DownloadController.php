<?php

namespace App\Http\Controllers;

use App\UploadLog;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    /**
     * Download the specified spreadsheet
     *
     * @param $id
     * @param $filename
     *
     * @return bool|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getSheet($id, $filename)
    {
        if (($redirect = $this->checkPermissions('CONFIG')) !== true) {
            return $redirect;
        }

        $log = UploadLog::getEntryByChapterId($id);

        if ($log->updateLog($filename, UploadLog::UPLOAD_STATUS_PROCESSING)) {
            // Download file
            return response()->download(storage_path('app/points/' .
                                                     str_slug($log['chapter_name'], '_') .
                                                     '/' . $filename));
        }
    }
}
