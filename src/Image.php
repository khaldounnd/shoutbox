<?php


namespace App;


class Image
{

    /**
     * @param $img
     * @return string
     */
    public function upload($img)
    {
        $filename = $img['name'];

        /* Location */
        $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        $location = "uploads/". md5(rand() . date('Y-m-d h:i:s')) . ".$imageFileType";

        /* Valid extensions */
        $valid_extensions = array("jpg","jpeg","png");

        /* Check file extension */
        if(in_array(strtolower($imageFileType), $valid_extensions)) {
            /* Upload file */
            if(move_uploaded_file($img['tmp_name'], $location)){
                return $location;
            }
        }

        header('HTTP/1.1 500 Internal Error');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode('Unable to Upload File');
        die();

    }

    public function deleteImage($img)
    {
        try {
            unlink($_SERVER['DOCUMENT_ROOT']. $img['message']);
        } catch (\Exception $exception) {
            header('HTTP/1.1 500 Internal Error');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode('Unable to Delete Image');
            die();
        }
    }

}