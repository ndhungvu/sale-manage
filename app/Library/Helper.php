<?php 
namespace App\Library;
use Intervention\Image\Facades\Image as Image;
use Excel;
 
class Helper{ 
    public static function pr($data) {
        echo '<pre>'; print_r($data); echo '<pre>';
    }

    public static function hashID() {
        return md5(time().rand(1, 1000000));
    }

    public static function hash() {
        return substr(md5(time().rand(1, 1000000)),0,8);
    }

    /*This is function create slug of title*/   
    public static function slug($model, $value)
    {
        $slug = \Illuminate\Support\Str::slug($value);
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());
        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public static function resizeImage($image_root_path, $thumb_type = 'A', $path = 'uploads/images/') {
        switch ($thumb_type) {
            case 'A':           
                $width = '100';
                $height = '100';
                break;
            case 'B':
                $width = '150';
                $height = '150';
                break;
            case 'C':
                $width = '200';
                $height = '200';
                break;
            case 'D':
                $width = '400';
                $height = '400';
                break;
            case 'E':
                $width = '1000';
                $height = '500';
                break;
            default:
                $width = '';
                $height = '';
                break;
        }
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        /*Get file name of image root*/
        $path_parts = pathinfo($image_root_path);        
        $file_name = $path_parts['filename'];
        $ext = $path_parts['extension'];

        if(!empty($width) && !empty($height)) {
            $path = $path.$file_name.'-'.$width.'x'.$height.'.'.$ext;            
            if(Image::make($image_root_path)->resize($width, $height)->save($path))
                return $path;
        }else {
            $path = $path.$file_name.'.'.$ext;
            if(Image::make($image_root_path)->save($path))
                return $path;
        }       
        return '';
    }

    function getThumbImage($image, $thumb_type = 'A', $path = 'uploads/image/') {
       switch ($thumb_type) {
            case 'A':
                $type = '-120x120';
                break;
            case 'B':
                $type = '-400x150';
                break;
            case 'C':
                $type = '-400x300';
                break;
            case 'D':
                $type = '-1400x600';
                break;
        }
        
        /*Get file name of image root*/
        $path_parts = pathinfo($image);        
        $file_name = $path_parts['filename'];
        $ext = $path_parts['extension'];

        $path = $path.$file_name.$type.'.'.$ext;
        
        return $path;
    }

    /*
    *Get gender
    *@param int $key
    *@rerurn string.
    */
    public static function getGender($key) {
        return $key == 1 ? 'Nam' : 'Nữ';
    }

    /*
    *Export data to file
    *@param array $header, array $content, string $path, string $ext 
    *@rerurn file data.
    */
    public static function export($header = null, $contents = null, $name= 'export', $ext='xls') {
        Excel::create($name, function($excel) use($header, $contents) {
             $excel->sheet('Sheetname', function($sheet) use($header, $contents){
                $i = 1;
                /*Header*/
                $sheet->row($i, $header, null, 'A1', false, false);                
                $sheet->row($i, function($row) {
                    $row->setBackground('#107EEE')->setFontColor('#FFFFFF')
                        ->setFontSize(12)->setFontWeight('bold');
                });
                $sheet->setHeight($i, 20);                
                /*Content*/
                foreach ($contents as $key => $content) {
                    $sheet->row(++$i, $content);                    
                }
            });
        })->download($ext);
    }

    public static function thousandSeparator($price) {
        return preg_replace('/(?<=\d),(?=\d{3}\b)/','',$price);
    }
}