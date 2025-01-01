<?php
use App\User;
use Illuminate\Encryption\Encrypter;

if (!function_exists('_pre')) {
    function _pre($array, $exit = 1)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        if ($exit == 1) {
            exit();
        }
    }
}

if (!function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
if (!function_exists('_set_flashdata')) {
    /**
    $type = 1 for Toast, 2 for HTML
     */
    function _set_flashdata($msg_type = 'S', $obj=null, $type = 'FLASH_TOAST'){
        $notification_msg = '';
        if(is_object($obj)){
            if(!empty($obj)){
                foreach($obj as $k=>$v){
                    $notification_msg .= ($notification_msg) ? "<br>".$v : $v;
                }
            }
        }else{
            $notification_msg  = $obj;
        }

        Session::flash('FLASH_TYPE', $type);
        Session::flash('FLASH_STATUS', $msg_type);
        Session::flash('FLASH_MESSAGE', $notification_msg);
    }
}

if (!function_exists('_notify')) {
    function _notify(){
        // dd(session('FLASH_TYPE'));
        if(Session::has('FLASH_MESSAGE')){
            if(session('FLASH_TYPE') == 'FLASH_HTML'){
                if(Session::has('FLASH_STATUS') && Session::has('FLASH_MESSAGE')){
                    echo( _notification( session('FLASH_STATUS'), session('FLASH_MESSAGE') ) );
                }
            }else{
                if(session('FLASH_TYPE') == 'FLASH_TOAST'){
                    _notification_js();
                }
            }
        }

        if(!Session::has('FLASH_MESSAGE')){
            _set_flashdata('E', '');
        }
    }
}

if (!function_exists('_notification_js')) {
    function _notification_js(){
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                <?php
                    if(session('FLASH_STATUS') == 'S'){
                        if(session('FLASH_MESSAGE') != ''){
                ?>
                toastr.success('<?= session('FLASH_MESSAGE') ?>', 'Success');
                <?php
                        }
                ?>
                //toastr.error('<?php //echo session('FLASH_MESSAGE') ?>', 'Error');
                //toastr.warning('<?php //echo session('FLASH_MESSAGE') ?>', 'Warning');
                //toastr.info('<?php //echo session('FLASH_MESSAGE') ?>', 'Info');
                <?php
                    }else if(session('FLASH_STATUS') == 'E'){
                        if(session('FLASH_MESSAGE') != ''){
                ?>
                toastr.error('<?= session('FLASH_MESSAGE') ?>', 'Error');
                <?php
                        }
                    }else if(session('FLASH_STATUS') == 'W'){
                        if(session('FLASH_MESSAGE') != ''){
                ?>
                toastr.warning('<?= session('FLASH_MESSAGE') ?>', 'Warning');
                <?php
                        }
                    }
                    else if(session('FLASH_STATUS') == 'I')
                    {
                        if(session('FLASH_MESSAGE') != '')
                        {
                ?>
                toastr.info('<?= session('FLASH_MESSAGE') ?>', 'Info');
                <?php
                        }
                    }
                ?>
            });
        </script>
    <?php }
}

if (!function_exists('_notification')) {
    function _notification($type='S', $msg='Hello ! This is notification.'){
        $notification_html = '';
        if($type == 'S'){
            $type = 'alert-success';
        }
        if($type == 'E'){
            $type = 'alert-danger';
        }
        if($type == 'SE'){
            $type = 'alert-secondary';
        }
        if($type == 'P'){
            $type = 'alert-primary';
        }
        if($type == 'W'){
            $type = 'alert-warning';
        }
        if($type == 'I'){
            $type = 'alert-info';
        }
        if($type == 'L'){
            $type = 'alert-light';
        }
        if($type == 'D'){
            $type = 'alert-dark';
        }

        $notification_html .= '<div class="alert '.$type.' alert-dismissible" style="margin-top: 55px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    '.$msg.'
                                </div>' ;
        return $notification_html;
    }
}

function getRealQuery($query, $dumpIt = true){
    $params = array_map(function ($item) {
        return "'{$item}'";
    }, $query->getBindings());

    $result = str_replace_array('\?', $params, $query->toSql());

    if($dumpIt){
        _pre($result);
    }

    return $result;
}

if (!function_exists('date_time')) {
    function date_time($text, $format = '', $time = ''){
        if ($text == "" || $text == "0000-00-00 00:00:00" || $text == "0000-00-00")
            return "---";
        switch ($format) {
            //us formate
            case "1":
                return date('d/m/Y', strtotime($text));
                break;
            case "2":
                return date('H:i:s ', strtotime($text));
                break;
            case "3":
                return date("jS F, Y", strtotime($text));
                break;
            case "4":
                return date("jS F, Y H:i A", strtotime($text));
                break;
            case "5":
                return date('l, F j, Y', strtotime($text));
                break;
            case "6":
                return date('g:i:s', $text);
                break;
            case "7":
                return date('F j, Y  h:i A', strtotime($text));
                break;
            case "8":
                return date('Y-m-d', strtotime($text));
                break;
            case "9":
                return date('F j, Y', strtotime($text));
                break;
            case "10":
                return date('d/m/Y', strtotime($text));
                break;
            case "11":
                return date('m/d/y', strtotime($text));
                break;
            case "12":
                return date('H:i', strtotime($text));
                break;
            case "13":
                return date('M j, Y h:i a', strtotime($text));
                break;
            case "14":
                return date('j-M-Y', strtotime($text));
                break;
            case "15":
                return date('D', strtotime($text));
                break;
            case "16":
                return date('d', strtotime($text));
                break;
            case "17":
                return date('M Y', strtotime($text));
                break;
            case "18":
                return date('h:i A', strtotime($text));
                break;
            case "19":
                return date('M j, Y', strtotime($text));
                break;
            case "20":
                return date('l,F d', strtotime($text));
                break;
            case "21":
                return date('m/d/y, l', strtotime($text));
                break;
            //Use below(22-23-24) date time format in whole site
            //For Time - 01:00 AM
            case "22":
                return date('h:i A', strtotime($text));
                break;
            //For date 10 Mar 2016
            case "23":
                return date('j M Y', strtotime($text));
                break;
            //For Date and Time  28 Mar 2016 01:00 AM
            case "24":
                return date('j M Y', strtotime($text)) . ' ' . date('h:i A', strtotime($time));
                break;
            //For DateTime type
            case "25":
                return date('j M Y  h:i A', strtotime($text));
                break;
            case "26":
                return date("jS M, Y", strtotime($text));
                break;
            case "27":
                return date("jS M, Y h:i:s a", strtotime($text));
                break;
            case "28":
                return date("jS M, Y H:i:s", strtotime($text));
                break;
            case "29":
                return date("d.m.Y", strtotime($text));
                break;
            case "30":
                return date("d.m.Y H:i:s", strtotime($text));
                break;
            case "31":
                return date("j F Y", strtotime($text));
                break;
            case "32":
                return date("d-m-Y H:i", strtotime($text));
                break;
            case "33":
                return date("d-m-Y", strtotime($text));
                break;
            case "34":
                return date("d, m/Y", strtotime($text));
                break;
            case "35":
                return date("d F Y", strtotime($text));
                break;

            default :
                return date('Y-m-d', strtotime($text));
                break;
        }
    }
}

if (!function_exists('day_diff_from_current')) {
    function day_diff_from_current($date1, $date2){
        $interval = $date1->diff($date2);
        if($interval->invert == 1){
            $diff = ' ';
            if ($interval->y != 0) {
                $diff .= $interval->y . ' Yr ';
            }
            if ($interval->m != 0) {
                $diff .= $interval->m . ' mnth ';
            }
            if ($interval->d != 0) {
                $diff .= $interval->d . ' d ';
            }
            if ($interval->h != 0) {
                $diff .= $interval->h . ' h ';
            }
            if ($interval->i != 0) {
                $diff .= $interval->i . ' m ';
            }
            return $diff;
        }else{
            $diff = ' ';
            if ($interval->y != 0) {
                $diff .= $interval->y . ' Yr ';
            }
            if ($interval->m != 0) {
                $diff .= $interval->m . ' mnth ';
            }
            if ($interval->d != 0) {
                $diff .= $interval->d . ' d ';
            }
            if ($interval->h != 0) {
                $diff .= $interval->h . ' h ';
            }
            if ($interval->i != 0) {
                $diff .= $interval->i . ' m ';
            }
            return $diff;
        }
    }
}

/* Curl For Get Request API*/
if(!function_exists('get_request_api_data')){
    function get_request_api_data($url, $jsonData=''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

if(!function_exists('_object_array_search')){
    function _object_array_search($array, $index, $value){
        foreach ($array as $arrayInf) {
            if ($arrayInf->{$index} == $value) {
                return $arrayInf;
            }
        }
        return null;
    }
}

if (!function_exists('_set_dash')) {
    function _set_dash($str = ''){
        $str = trim($str);
        if ($str == '') {
            $str = '-';
        }
        return $str;
    }
}

if (!function_exists('_random_string')) {
    function _random_string($length = 8){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!_#^*';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = str_shuffle($randomString);
        return $randomString;
    }
}

if (!function_exists('_random_digit')) {
    function _random_digit($length = 4){
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = str_shuffle($randomString);
        return $randomString;
    }
}

if (!function_exists('_encrypt_decrypt')) {
    function _encrypt_decrypt($type, $data){
        $from_key = "2ywk0281BYriiu@DGf6y@cBab95E^rh3";
        $cipher = "AES-256-CBC";
        $encrypterFrom = new Encrypter($from_key, $cipher);

        if($type == 'encrypt'){
            $encryptedToString = $encrypterFrom->encryptString($data);
            return $encryptedToString;
        }else if($type == 'decrypt'){
            $decryptedFromString = $encrypterFrom->decryptString($data);
            return $decryptedFromString;
        }
    }
}

if (!function_exists('_categoryTree')) {
    function _categoryTree($table_name, $parent_id = 0, $sub_mark = '', $selected_category='')
    {
        $category = DB::table($table_name)
            ->where('parent_cat_id', $parent_id)
            ->select('*')
            ->get();

        if(!$category->isEmpty()){
            foreach($category as $key => $value){
                if($selected_category != ''){
                    if($selected_category == 0){
                        //
                    }else{
                        $option = '<option ';
                        if($value->id == $selected_category){
                            $option .= 'selected ';
                        }
                        $option .= 'value="'.$value->id.'">'.$sub_mark.$value->cat_name.'</option>';
                        echo $option;
                        _categoryTree($table_name, $value->id, $sub_mark.'&nbsp;&nbsp;&nbsp;', $selected_category);
                    }
                }else{
                    echo '<option value="'.$value->id.'">'.$sub_mark.$value->cat_name.'</option>';
                    _categoryTree($table_name, $value->id, $sub_mark.'&nbsp;&nbsp;&nbsp;');
                }
            }
        }
    }
}

if (!function_exists('_category_list_dash')) {
    function _category_list_dash($table_name, $parent_id = 0, $sub_mark = '', $id='', &$sub_category_array=array()){
        if($parent_id == 0){
            $category = DB::table($table_name)
                ->where('parent_cat_id', $parent_id)
                ->where('id', $id)
                ->select('*')
                ->get();
        }else{
            $category = DB::table($table_name)
                ->where('parent_cat_id', $parent_id)
                ->select('*')
                ->get();
        }

        if(!$category->isEmpty()){
            foreach($category as $key => $value){
                // echo $sub_mark.$value->cat_name.'<br>';
                $tempStdClassObject = $value;
                $tempStdClassObject->cat_name_dash = $sub_mark.$value->cat_name;
                array_push($sub_category_array, $tempStdClassObject);
                _category_list_dash($table_name, $value->id, $sub_mark.' - ', $id, $sub_category_array);
            }
        }
    }
}


?>