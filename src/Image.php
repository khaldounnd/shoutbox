<?php


namespace App;


class Image
{

    /**
     * Upload Image Method
     * @param array<string> $img
     * @return string
     */
    public function upload(array $img): string
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

    /**
     * Delete Image Method
     * @param array<string> $img
     */
    public function delete(array $img) : void
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