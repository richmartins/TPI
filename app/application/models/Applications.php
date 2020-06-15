<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Applications
 */
class Applications extends CI_Model {
    private $raw;
    private $rawArray;
    
    /**
     * __construct
     *
     * @return void
     */
    function __construct() {
        $this->raw = json_decode(file_get_contents( getcwd() . '/public/installer_scripts.json'));
        $this->rawArray = json_decode(file_get_contents( getcwd() . '/public/installer_scripts.json'), true);
    }
        
    /**
     * getApplications
     *
     * @return Object 
     */
    function getApplications(){
        return $this->raw;
    }
    
    /**
     * checkApplicationsExsits
     *
     * @param  String $name
     * @return Boolean
     */
    function checkApplicationsExsits($name){
        foreach($this->raw->command as $k => $obj){
            if($obj->name === $name){
                return true;
            }
        }
        return false;
    }


    /**
     * getNewId
     *
     * @return int
     */
    function getNewId(){
        $id = count($this->rawArray['command']);
        return (int) $id;
    }

    /**
     * give script in function of id passed
     * @args Int id
     * @return mixed
     */
    function getScript($id) {
        foreach($this->raw->command as $k => $obj) {
            if($id == $k){
                return $obj;
            }
        }
        return $error = 'No script was found';
    }

    /**
     * updateScript
     *
     * @param  String $name
     * @param  Int $id
     * @param  String $newScript
     * @return mixed
     */
    function updateScript($name, $id, $newScript) {
        
        if(self::checkApplicationsExsits($name)){
            $newData = [
                'name'  => $name,
                'shell' => $newScript
            ];

            unset($this->rawArray['command'][$id]);
            $this->rawArray['command'][$id] = $newData;
            $this->rawArray['command'] = array_values($this->rawArray['command']);
            //encode to json to save
            $result = file_put_contents(FCPATH . "public/installer_scripts.json", json_encode($this->rawArray));
            if(is_bool($result)) {
                $error = 'An error occured while updating the file, please try again, or contact the webmaster';
                return $error;
            }else {
                return true;
            }
        }
    }

    /**
     * deleteApplication
     *
     * @param  String $name
     * @param  Int $id
     * @return mixed
     */
    function deleteApplication($name, $id){
        

        if($this->rawArray) {
            unset($this->rawArray["command"][$id]);
            $this->rawArray["command"] = array_values($this->rawArray["command"]);
            file_put_contents( FCPATH . "public/installer_scripts.json", json_encode($this->rawArray));
            unlink( FCPATH .  '/public/app-icons/' . $name . '.png');
        }

        if(!self::checkApplicationsExsits($name)){
            $error = 'Could not delete the script of ' . $name;
            return $error;
        }

        if(file_exists(FCPATH .'/public/app-icons/' . $name  .'png')){
            $error = 'Could not delete image file ' . $name . '.png ';
            return $error;
        }
        return true;
    }

    /**
     * add
     *
     * @param  String $name
     * @param  Int $id
     * @param  String $shell
     * @return mixed
     */
    function add($name, $id, $shell){
        
        // var_dump($this->rawArray);
        if($this->rawArray !== null) {
            $this->rawArray['command'][$id]['name'] = $name;
            $this->rawArray['command'][$id]['shell'] = $shell;

            foreach(array_keys($this->rawArray) as $v){
                $v = iconv('UTF-8','ISO-8859-9', $v);
            }

            $new_json = json_encode($this->rawArray);

            return file_put_contents( FCPATH . 'public/installer_scripts.json', $new_json);
        }

        if(!self::checkApplicationsExsits($name)){
            $error = "Could not add new script";
            return $error;
        }

        if(file_exists(FCPATH . '/public/app-icons/' . $name . 'png')){
            $error = "Could not add image to script";
            return $error;
        }
    }
}
