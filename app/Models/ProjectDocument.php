<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectDocument extends Pivot
{
    protected $table = 'project_documents';

    protected $fillable = ['id', 'project_id', 'name', 'path'];

    public function getTitle() {
        if(is_null($this->name) || empty($this->name)) {
            $pathInfo = pathinfo($this->path);

            return $pathInfo['filename'];
        }

        return $this->name;
    }

    public function getSize() {
        $fileFullPath = public_path() . '/' . $this->path;

        $sizeInBytes = filesize($fileFullPath);

        return Helper::bytesToHumanReadableSize($sizeInBytes);
    }

    public function getIconSrc() {
        $knownExtensions = ['xls', 'xlsx', 'doc', 'docx', 'pdf', 'csv'];

        $ext = array_last(explode('.', $this->path));

        if(!in_array($ext, $knownExtensions)) {
            $ext = 'file';
        }

        return asset('images/ext-icons/'.$ext.'.png');
    }

    public function delete() {
        try {
            unlink(public_path().'/'.$this->path);

            parent::delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
