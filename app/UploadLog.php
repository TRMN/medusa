<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Class UploadLog.
 *
 * @property string chapter_id
 * @property string chapter_name
 * @property array files
 */
class UploadLog extends Eloquent
{
    protected $fillable = [
        'chapter_id',
        'chapter_name',
        'files',
    ];

    const UPLOAD_STATUS_UPLOADED = 'Uploaded';
    const UPLOAD_STATUS_PROCESSING = 'In Process';
    const UPLOAD_STATUS_IMPORTED = 'Imported';
    const LOG_MESSAGES = [
        'Uploaded' => 'Uploaded',
        'In Process' => 'Downloaded for processing',
        'Imported' => 'Imported',
    ];

    /**
     * Has this file been uploaded for this chapter before.
     *
     * @param string $originalFileName
     *
     * @return bool
     */
    public function isDuplicate(string $originalFileName)
    {
        if (empty($this->files) === false) {
            foreach ($this->files as $fileName => $fileInfo) {
                if ($fileInfo['original_name'] === $originalFileName) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Add a new file to a chapters upload log.
     *
     * @param string $filename
     * @param string $status
     * @param string $originalFileName
     *
     * @return mixed
     */
    public function addNewFile(string $filename, string $status, string $originalFileName)
    {
        $files = $this->files;

        $files[str_replace('.', '_', $filename)] = [
            'filename' => $filename,
            'current_status' => $status,
            'original_name' => $originalFileName,
            'status_ts' => time(),
            'uploaded_by' => Auth::user()->id,
        ];

        $files[str_replace('.', '_', $filename)]['log'][] =
            self::LOG_MESSAGES[$status].' '.date('F j, Y @ g:i a');

        $this->files = $files;

        return $this->save();
    }

    /**
     * Update the status for the specified file.
     *
     * @param string $filename
     * @param string $status
     *
     * @return mixed
     */
    public function updateLog(string $filename, string $status)
    {
        $files = $this->files;
        $modifiedFileName = str_replace('.', '_', $filename);

        if (isset($files[$modifiedFileName])) {
            $file = $files[$modifiedFileName];
        } else {
            $file = [];
            $file['filename'] = $filename;
        }

        $file['current_status'] = $status;
        $file['status_ts'] = time();

        $file['log'][] = self::LOG_MESSAGES[$status].' '.date('F j, Y @ g:i a');

        $files[$modifiedFileName] = $file;

        $this->files = $files;

        return $this->save();
    }

    /**
     * Get an UploadLog entry for the specified chapter.
     *
     * @param string $id
     *
     * @return \Jenssegers\Mongodb\Eloquent\Model|null
     */
    public static function getEntryByChapterId(string $id)
    {
        return self::where('chapter_id', $id)->first();
    }
}
