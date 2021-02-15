<?php

namespace App\Http\Controllers;


use App\Model\ClientHistory;
use Illuminate\Http\Request;
use App\Model\TokenCache;
use App\Model\Client;
use App\Model\User;
use App\Model\Ignored_Email;
use DOMDocument;
use DOMXPath;
use DateTime;
use  DateTimeZone;

class EmailController extends Controller
{
    //

    public function read()
    {
        try{

            $tokenCache = new TokenCache();
            $accessToken = $tokenCache->getAccessToken();
            echo '<pre>';

            $users = $this->getUsers($accessToken);
            $last_created_leads = Client::max('added_at');
            $all_users = User::all();
            foreach ($users as $user)
            {

                if (!isset($user->mail)) continue;
                $bpermission = false;
                foreach ($all_users as $table_user){
                    if ($table_user->user == $user->mail && ($table_user->role == 'admin' || $table_user->role == 'AccMng' || $table_user->role == 'Surveyor')) {
                        $bpermission = true; break;
                    }
                }
                if (!$bpermission) continue;
                if ($user->mail!= 'iuliana@cornerstoneremovals.co.uk') continue;
                $user_ID = $user->id;
                $folders = $this->getmailFolders($accessToken, $user_ID);


                foreach ($folders as $folder)
                {
                    var_dump($folder->displayName);
                    if ($folder->displayName != 'leads') continue;

                    $mails = $this->getmailfromFolder($accessToken, $user_ID, $folder->id, 100);
                    foreach ($mails as $mail)
                    {
                        try{
                            $dt = $mail->createdDateTime;

                            //If this email's create time is 5min(max_email_tolerance, 300) ago from current timestamp
                            //if ($this->DifffromSeconds($dt) > env('max_email_tolerance')) break;

                            $sender = $mail->sender->emailAddress->address;

                            var_dump($sender);
                            if ($this->checkLeads($sender, $mail->body->content))
                            {
                                var_dump($mail->body->content);
                            } else {
                                $client = Client::where('email', '=', $sender)->first();
                                $ignored_email = Ignored_Email::where('email', '=', $sender)->first();
                                $client_history = new ClientHistory();
                                if ($ignored_email != null) {
                                    echo 'Ignored Email ' . $sender . '<br>';
                                    $client_history->client_id = 4300;
                                }else {
                                    if ($client == null) {
                                        echo 'No Client, new email  '.'<br>';
                                        $client_history->client_id = 4229;
                                    } else {
                                        echo 'Client exists '.$client->email.'<br>';
                                        $client_history->client_id = $client->client_id;
                                    }
                                }
                                $client_history->folder = $folder->displayName;
                                $client_history->notes = $mail->body->content;
                                $client_history->type = 'read_email';
                                $client_history->saved_at = new DateTime($dt);
                                $client_history->added_at = time();
                                $client_history->save();

                            }
                        }catch (\Exception $me){
                            var_dump($me->getMessage());
                        }

                    }

                }
                echo '=============================='.'<br>';
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
    public function checkLeads($mailaddress, $content)
    {
        switch ($mailaddress) {
            case 'leads@pinlocal.com':
                $client = $this->analyzePinlocal($content);
                return true;
                break;
            case 'info@moveadvisor.com':
                $client = $this->analyzeMoveadvisor($content);
                return true;
                break;
            case 'autoquote@reallymoving.com':
                $client = $this->analyzeReallymoving($content);
                return true;
                break;
            case  'accounts@comparemymove.com':
                $client = $this->analyzeComparemymove($content);
                return true;
                break;
            default:
                return false;
        }
        return false;
    }
    public function analyzeComparemymove($content){
        $res = [];
        $res['customer'] =[];
        $res['notes'] = [];
        $client = new Client();

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $nodes = $xpath->query('//*[@id="templateColumns"]/table[1]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/text()');
        if (count($nodes)) $res['customer']['fullName'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[1]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/a[1]');
        if(count($nodes)) $res['customer']['phone'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[1]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/a[2]');
        if (count($nodes)) $res['customer']['email'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[2]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/strong[1]');
        if(count($nodes)) $res['movingDate'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[2]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/strong[2]');
        if(count($nodes)) $res['notes']['flexible'] = $nodes->item(0)->nodeValue;

        $ele = $xpath->query('//*[@id="bodyCell"]/table/tbody/tr[7]//*[@id="templateColumns"]/table[1]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/strong/text()');
        $res['currentAddr'] = [];
        foreach ($ele as $item){
            $res['currentAddr'][] = $item->nodeValue;
        }
        $ele = $xpath->query('//*[@id="bodyCell"]/table/tbody/tr[7]//*[@id="templateColumns"]/table[2]/tbody/tr[2]/td/table/tbody/tr/td/table/tbody/tr/td/strong/text()');
        $res['newAddr'] = [];
        foreach ($ele as $item){
            $res['newAddr'][] = $item->nodeValue;
        }
        $res['currentProp'] = [];
        $res['newProp'] = [];
        $res['currentProp']['bedRooms'] = $xpath->query('//*[@id="templateColumns"]/table[1]/tbody/tr[3]/td/table/tbody/tr/td/table/tbody/tr/td/strong[1]')->item(0)->nodeValue;
        $res['currentProp']['homeType'] = $xpath->query('//*[@id="templateColumns"]/table[1]/tbody/tr[3]/td/table/tbody/tr/td/table/tbody/tr/td/strong[2]')->item(0)->nodeValue;
        $res['notes']['current_accessIssues'] = $xpath->query('//*[@id="templateColumns"]/table[1]/tbody/tr[3]/td/table/tbody/tr/td/table/tbody/tr/td/strong[3]')->item(0)->nodeValue;

        $nodes = $xpath->query('//*[@id="templateColumns"]/table[2]/tbody/tr[3]/td/table/tbody/tr/td/table/tbody/tr/td/strong[1]');
        if (count($nodes)) $res['newProp']['bedRooms'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[2]/tbody/tr[3]/td/table/tbody/tr/td/table/tbody/tr/td/strong[2]');
        if (count($nodes))$res['newProp']['homeType'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[2]/tbody/tr[3]/td/table/tbody/tr/td/table/tbody/tr/td/strong[3]');
        if (count($nodes)) $res['notes']['new_accessIssues'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[3]/tbody/tr/td/table[2]/tbody/tr/td/strong[1]');
        if (count($nodes)) $res['notes']['additionalServiceRequired'] = $nodes->item(0)->nodeValue;
        $nodes = $xpath->query('//*[@id="templateColumns"]/table[3]/tbody/tr/td/table[2]/tbody/tr/td/strong[2]');
        if (count($nodes)) $res['notes']['additionalInformation'] = $nodes->item(0)->nodeValue;


        $res['customer']['fullName'] = explode(' ', $res['customer']['fullName']);
        $client->client = base64_encode($res['customer']['fullName'][0]);
        $client->client_surname = (isset($res['customer']['fullName'][1]))?$res['customer']['fullName'][1]:'';
        $client->client_surname = base64_encode($client->client_surname);

        $client->email = $res['customer']['email'];
        $client->telephone = $res['customer']['phone'];
        $client->moving_date = $this->strtoDate($res['movingDate']);


        $addr = $this->getAddress2($res['currentAddr']);
        $client->pickup_line1 = $addr['line1'];
        $client->pickup_line2 = $addr['line2'];
        $client->pickup_city = $addr['city'];
        $client->pickup_postcode = $addr['postCode'];
        $client->address = base64_encode($client->pickup_line1.' '. $client->pickup_line2.', '.$client->pickup_city. ', '.$client->pickup_postcode);

        if (isset($res['currentProp']['homeType']) && isset($res['currentProp']['bedRooms']))
            $client->pickup_building = $res['currentProp']['homeType'].' - '.$res['currentProp']['bedRooms'].' Bedrooms';

        $addr = $this->getAddress2($res['newAddr']);
        $client->delivery_line1 = $addr['line1'];
        $client->delivery_line2 = $addr['line2'];
        $client->delivery_city = $addr['city'];
        $client->delivery_postcode = $addr['postCode'];
        $client->delivery_address = base64_encode($client->delivery_line1. ' '.$client->delivery_line2. ', '.$client->delivery_city. ', '.$client->delivery_postcode);
        if (isset($res['newProp']['homeType']) && isset($res['newProp']['bedRooms']))
            $client->delivery_building = $res['newProp']['homeType'].' - '.$res['newProp']['bedRooms'].' Bedrooms';
        $client->notes = json_encode($res['notes']);
        $client->client_id = Client::max('client_id') + 1;
        $client->save();
        return $client;
    }
    public function analyzeReallymoving($content)
    {
        $res = [];
        $res['customer'] = [];
        $res['customerMoreinfo'] = [];
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($content);

        libxml_clear_errors();
        $xpath = new DOMXPath($dom);
        $res['customer']['fullName'] = $xpath->query('/html/body/table/tbody/tr[1]/td/table/tbody/tr[3]/td[2]')->item(0)->nodeValue;
        $res['customer']['email'] = $xpath->query('/html/body/table/tbody/tr[1]/td/table/tbody/tr[4]/td[2]/a/font')->item(0)->nodeValue;
        $res['customer']['phone'] = $xpath->query('/html/body/table/tbody/tr[1]/td/table/tbody/tr[5]/td[2]')->item(0)->nodeValue;
        $res['customerMoreinfo']['moveSize'] = $xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[1]/td[2]')->item(0)->nodeValue;
        $res['customerMoreinfo']['moveDistance'] = $xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[3]/td[2]')->item(0)->nodeValue;
        $res['customerMoreinfo']['estimatMovedate'] = $xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[4]/td[2]')->item(0)->nodeValue;
        $value = $xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[6]/td[2]/text()');
        $res['customerMoreinfo']['movingFrom'] = [];
        foreach ($value as $item)
        {
            $res['customerMoreinfo']['movingFrom'][] = $item->nodeValue;
        }

        $value = $xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[9]/td[2]/text()');
        $res['customerMoreinfo']['movingTo'] = [];
        foreach ($value as $item)
        {
            $res['customerMoreinfo']['movingTo'][] = $item->nodeValue;
        }

        $res['customerMoreinfo']['specialInstructions'] = $xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[12]/td[2]')->item(0)->nodeValue;
        $res['customerMoreinfo']['totalPrice'] = $xpath->query('/html/body/table/tbody/tr[5]/td/table/tbody/tr[3]/td[2]/strong')->item(0)->nodeValue;

        $client = new Client();
        $res['customer']['fullName'] = explode(' ', $res['customer']['fullName']);
        $client->client = base64_encode($res['customer']['fullName'][0]);
        $client->client_surname = (isset($res['customer']['fullName'][1]))?$res['customer']['fullName'][1]:'';
        $client->client_surname = base64_encode($client->client_surname);

        $client->email = $res['customer']['email'];
        $client->telephone = $res['customer']['phone'];

        $addr = $this->getAddress1($res['customerMoreinfo']['movingFrom']);
        $client->pickup_line1 = $addr['line1'];
        $client->pickup_line2 = $addr['line2'];
        $client->pickup_city = $addr['city'];
        $client->pickup_postcode = $addr['postCode'];
        $client->address = base64_encode($client->pickup_line1.' '. $client->pickup_line2.', '.$client->pickup_city. ', '.$client->pickup_postcode);

        $client->pickup_building = $res['customerMoreinfo']['moveSize'];
        $client->moving_date = $this->strtoDate($res['customerMoreinfo']['estimatMovedate']);

        $addr = $this->getAddress1($res['customerMoreinfo']['movingTo']);
        $client->delivery_line1 = $addr['line1'];
        $client->delivery_line2 = $addr['line2'];
        $client->delivery_city = $addr['city'];
        $client->delivery_postcode = $addr['postCode'];
        $client->delivery_address = base64_encode($client->delivery_line1. ' '.$client->delivery_line2. ', '.$client->delivery_city. ', '.$client->delivery_postcode);

        $notes = [];
        $notes['totalPrice'] = $res['customerMoreinfo']['totalPrice'];
        $notes['specialInstructions'] = $res['customerMoreinfo']['specialInstructions'];
        $client->notes = json_encode($notes);
        $client->client_id = Client::max('client_id') + 1;

        $client->save();
        return $client;

    }
    public function getAddress2($str){
        $res = [];
        $res['postCode'] = '';
        $res['city'] = '';
        $res['line2']= '';
        $res['line1'] = '';

        if (count($str) == 5){
            $res['line1'] = trim($str[0], ',').' '.trim($str[1], ',');
            $res['line2'] = trim($str[2], ',');
            $res['city'] = trim($str[3], ',');
            $res['postCode'] = trim($str[4], ',');
        }elseif (count($str) == 4){
            $res['line1'] = trim($str[0], ',');
            $res['line2'] = trim($str[1], ',');
            $res['city'] = trim($str[2], ',');
            $res['postCode'] = trim($str[3], ',');
        }elseif (count($str) == 3){
            $temp =  trim($str[0], ',');
            if (is_numeric($temp[0])) $res['line1'] = $temp;
            else $res['line2']  = $temp;
            $res['line1'] = trim($str[0], ',');
            $res['city'] = trim($str[1], ',');
            $res['postCode'] = trim($str[2], ',');
        }
        return $res;
    }
    public function getAddress1($str)
    {
        $res = [];
        $res['postCode'] = '';
        $res['city'] = '';
        $res['line2']= '';
        $res['line1'] = '';

        if (count($str) == 4){
            $res['line1'] = $str[0].' '.$str[1];
            $res['line2'] = $str[2];
            $temp = explode('(', $str[3]);
            $res['city']=trim($temp[0]);
            $res['postCode'] = trim(explode(')', $temp[1])[0]);
        }elseif (count($str) == 3){
            $res['line1'] = $str[0];
            $res['line2'] = $str[1];
            $temp = explode('(', $str[2]);
            $res['city']=trim($temp[0]);
            $res['postCode'] = trim(explode(')', $temp[1])[0]);
        }elseif (count($str ) == 2){
            $temp = $str[0];
            if (is_numeric($temp[0])) $res['line1'] = $temp;
            else $res['line2'] = $temp;
            $temp = explode('(', $str[1]);
            $res['city']=trim($temp[0]);
            $res['postCode'] = trim(explode(')', $temp[1])[0]);
        }
        return $res;
    }
    public function analyzeMoveadvisor($content){

        $res = [];
        $res['customer'] = [];
        $res['customerMoreinfo'] = [];
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $res['customer']['fullName'] = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[1]/td/table/tbody/tr[2]/td/text()')->item(0)->nodeValue);

        $res['customer']['phone'] = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[1]/td/table/tbody/tr[3]/td/a')->item(0)->nodeValue);
        $res['customer']['email'] = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[1]/td/table/tbody/tr[4]/td/a')->item(0)->nodeValue);

        $res['customerMoreinfo']['moveDate']  = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[2]/td/table/tbody/tr[2]/td/text()')->item(0)->nodeValue);
        $res['customerMoreinfo']['moveSize']  = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[2]/td/table/tbody/tr[3]/td/text()')->item(0)->nodeValue);
        $res['customerMoreinfo']['movingFrom']  = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[2]/td/table/tbody/tr[4]/td/text()')->item(0)->nodeValue);
        $res['customerMoreinfo']['movingTo']  = trim($xpath->query('/html/body/table/tbody/tr[3]/td/table/tbody/tr[2]/td/table/tbody/tr[5]/td/text()')->item(0)->nodeValue);

        $client = new Client();
        $res['customer']['fullName'] = explode(' ', $res['customer']['fullName']);
        $client->client = base64_encode($res['customer']['fullName'][0]);
        $client->client_surname = (isset($res['customer']['fullName'][1]))?$res['customer']['fullName'][1]:'';
        $client->client_surname = base64_encode($client->client_surname);
        $client->telephone = $res['customer']['phone'];
        $client->email = $res['customer']['email'];
        $client->moving_date = $this->strtoDate($res['customerMoreinfo']['moveDate']);

        $client->pickup_building = $res['customerMoreinfo']['moveSize'];
        $client->address = base64_encode($res['customerMoreinfo']['movingFrom']);
        $client->pickup_postcode = explode(',', $res['customerMoreinfo']['movingFrom'])[3];
        $client->pickup_city = explode(',', $res['customerMoreinfo']['movingFrom'])[2];
        $client->delivery_address = base64_encode($res['customerMoreinfo']['movingTo']);
        $client->delivery_postcode = explode(',', $res['customerMoreinfo']['movingTo'])[3];
        $client->delivery_city = explode(',', $res['customerMoreinfo']['movingTo'])[2];
        $client->client_id = Client::max('client_id') + 1;

        $client->save();
        return $client;

    }
    public function analyzePinlocal($content){
        $res = [];
        $res['personal'] = [];
        $res['movingTo'] = [];
        $res['otherservices'] = [];

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($content);

        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $trs = $xpath->query('//table/tbody/tr');

        foreach ($trs as $i => $tr)
        {
            $value = $tr->nodeValue;
            if (strpos($value, "First Name:") !== false)
            {
                $res['personal']['firstName'] = trim(explode("First Name:", $value)[1]);
            } else if (strpos($value, "Last Name:") !== false){
                $res['personal']['lastName'] = trim(explode("Last Name:", $value)[1]);
            } else if (strpos($value, "Address Line1:") !== false && $i < 15){
                $res['personal']['addressLine1'] = trim(explode("Address Line1:", $value)[1]);
            }else if (strpos($value, "Address Line2:") !== false && $i < 15){
                $res['personal']['addressLine2'] = trim(explode("Address Line2:", $value)[1]);
            }else if (strpos($value, "City:") !== false ){
                $res['personal']['city']  = trim(explode("City:", $value)[1]);
            }else if (strpos($value, "PostCode:") !== false ){
                $res['personal']['postCode']  = trim(explode("PostCode:", $value)[1]);
            }else if (strpos($value, "Email:") !== false ){
                $res['personal']['email']  = trim(explode("Email:", $value)[1]);
            }else if (strpos($value, "Phone:") !== false ){
                $res['personal']['phone']  = trim(explode("Phone:", $value)[1]);
            }else if (strpos($value, "Number of Bedrooms") !== false ){
                $res['personal']['numberofBedrooms']  = trim(explode("Number of Bedrooms", $value)[1]);
            }else if (strpos($value, "Property Type") !== false && $i<20 ){
                $res['personal']['propertyType']  = trim(explode(":", $value)[1]);
            }else if (strpos($value, "Address Line1") !== false && $i >= 15 ){
                $res['movingTo']['addressLine1']  = trim(explode("Address Line1", $value)[1]);
            }else if (strpos($value, "Address Line 2") !== false && $i >= 15 ){
                $res['movingTo']['addressLine2']  = trim(explode("Address Line 2", $value)[1]);
            }else if (strpos($value, "Town / City") !== false && $i >= 15 ){
                $res['movingTo']['city']  = trim(explode("Town / City", $value)[1]);
            }else if (strpos($value, "Post Code") !== false && $i >= 15 ){
                $res['movingTo']['postCode']  = trim(explode("Post Code", $value)[1]);
            }else if (strpos($value, "Property Type") !== false && $i>=20 ){
                $res['movingTo']['propertyType']  = trim(explode(":", $value)[1]);
            }else if (strpos($value, "Packing Service Required") !== false && $i>=20 ){
                $res['otherservices']['packingserviceRequired']  = trim(explode(":", $value)[1]);
            }else if (strpos($value, "Dismantle / reassemble") !== false && $i>=20 ){
                $res['otherservices']['dismantle']  = trim(explode(":", $value)[1]);
            }else if (strpos($value, "Storage required") !== false && $i>=20 ){
                $res['otherservices']['storagerequired']  = trim(explode(":", $value)[1]);
            }else if (strpos($value, "Approx. Moving Date") !== false && $i>=20 ){
                $res['otherservices']['movingDate']  = trim(explode("Approx. Moving Date", $value)[1]);
            }else if (strpos($value, "Moving Distance") !== false && $i>=20 ){
                $res['otherservices']['movingDistance']  = trim(explode("Moving Distance", $value)[1]);
            }
            else if (strpos($value, "Additional information") !== false && $i>=20 ){
                $res['otherservices']['additionalInformation']  = trim(explode("Additional information", $value)[1]);
            }

        }

        $client = new Client();
        $client->client = (isset($res['personal']['firstName']))? $res['personal']['firstName']:'';
        $client->client = base64_encode($client->client);
        $client->client_surname = (isset($res['personal']['lastName']))?$res['personal']['lastName']: '';
        $client->client_surname = base64_encode($client->client_surname);

        $client->pickup_line1 = (isset($res['personal']['addressLine1']))?$res['personal']['addressLine1']:'';
        $client->pickup_line2 = (isset($res['personal']['addressLine2']))?$res['personal']['addressLine2']:'' ;
        $client->pickup_city = (isset($res['personal']['city']))?$res['personal']['city']:'' ;
        $client->pickup_postcode = (isset($res['personal']['postCode']))? $res['personal']['postCode']: '' ;
        $client->email = (isset($res['personal']['email']))?$res['personal']['email']:'' ;
        $client->mobile = (isset($res['personal']['phone']))?$res['personal']['phone']:'';
        $client->telephone = (isset($res['personal']['phone']))?$res['personal']['phone']:'';
        $client->address = base64_encode($client->pickup_line1.' '. $client->pickup_line2.', '.$client->pickup_city. ', '.$client->pickup_postcode);
        $client->pickup_postcode = (isset($res['personal']['postCode']))?$res['personal']['postCode']:'';
        $client->email = (isset($res['personal']['email']))?$res['personal']['email']:'';
        $client->telephone = (isset($res['personal']['phone']))?$res['personal']['phone']:'';
        $res['personal']['propertyType'] = (isset($res['personal']['propertyType']))?$res['personal']['propertyType']:'';
        $res['personal']['numberofBedrooms'] = (isset($res['personal']['numberofBedrooms']))?$res['personal']['numberofBedrooms']:'';
        $client->pickup_building = $res['personal']['propertyType'].' - '.$res['personal']['numberofBedrooms'];


        $client->delivery_line1 = (isset($res['movingTo']['addressLine1'])) ? $res['movingTo']['addressLine1']: '';
        $client->delivery_line2 = (isset($res['movingTo']['addressLine2']))?$res['movingTo']['addressLine2']:'';
        $client->delivery_city  = (isset($res['movingTo']['city']))?$res['movingTo']['city']:'';
        $client->delivery_postcode = (isset($res['movingTo']['postCode']))?$res['movingTo']['postCode']:'';
        $client->delivery_address = base64_encode($client->delivery_line1. ' '.$client->delivery_line2. ', '.$client->delivery_city. ', '.$client->delivery_postcode);
        $client->delivery_building = (isset($res['movingTo']['propertyType']))?$res['movingTo']['propertyType']:'';
        $client->moving_date = (isset($res['otherservices']['movingDate']))?$res['otherservices']['movingDate']:'';
        $client->moving_date = $this->strtoDate($client->moving_date);

        $notes = [];
        $notes['packingserviceRequired'] = (isset($res['otherservices']['packingserviceRequired']))?$res['otherservices']['packingserviceRequired']:'';
        $notes['dismantle'] = (isset($res['otherservices']['dismantle']))?$res['otherservices']['dismantle']:'';
        $notes['storagerequired'] = (isset($res['otherservices']['storagerequired']))?$res['otherservices']['storagerequired']:'';
        $notes['additionalInformation'] = (isset($res['otherservices']['additionalInformation']))?$res['otherservices']['additionalInformation']:'';
        $notes['movingDistance'] = (isset($res['otherservices']['movingDistance']))?$res['otherservices']['movingDistance']:'';
        $client->notes = json_encode($notes);
        $client->client_id = Client::max('client_id') + 1;
        $client->save();

        return $client;
    }
    public function getUsers($accessToken)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('Graph_base_url'). 'users',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. $accessToken,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response->value;
    }
    public function getchildFolders($accessToken, $user_ID, $parentFolder_ID)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('Graph_base_url'). 'users/'.$user_ID. '/mailFolders/' .$parentFolder_ID.'/childFolders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '. $accessToken,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response->value;
    }
    public function getmailFolders($accessToken, $user_ID)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('Graph_base_url'). 'users/'.$user_ID. '/mailFolders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '. $accessToken,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (!isset($response->value)) return null;
        $res = $response->value;
        foreach ($response->value as $folder)
        {
            if ($folder->childFolderCount > 0)
            {
                $childfolders = $this->getchildFolders($accessToken, $user_ID, $folder->id);
                $res = array_merge($res, $childfolders);
            }
        }
        return $res;
    }
    public function getmailfromFolder($accessToken, $user_iD, $folder_ID, $number, $skip = 0)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('Graph_base_url'). 'users/'. $user_iD. '/mailFolders/'.$folder_ID.'/messages?%24top='. $number. '&%24skip='. $skip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '. $accessToken
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        return $response->value;
    }
    public function DifffromSeconds($dt)
    {
        $dt = new DateTime($dt);
        $now = new DateTime("NOW", $dt->getTimezone());
        $diff = $now->getTimestamp() - $dt->getTimestamp();
        return $diff;
    }
    public function test()
    {
        $data = Ignored_Email::all();
        var_dump($data);
    }

    public function strtoDate($str)
    {
        $str = trim($str);
        $dt = explode("/", $str);
        $str =$dt[1]."/".$dt[0]."/".$dt[2];
        $res = new DateTime($str);
        return $res;
    }
    public function compareTwoTimestamp($dt1, $dt2)
    {
        $dt1 = new DateTime($dt1);
        $dt2 = new DateTime($dt2);
        return $dt1->getTimestamp() - $dt2->getTimestamp();
    }
    public function noclient(){
        if(session("UserID") == ""){
            return redirect("/");
        }

        $Title = "NoCleints Overview";
        $noclients = ClientHistory::where('client_id', 4229)->get();
        return view('emails.noclient', compact('noclients', 'Title'));

    }
    public function noclient_edit($id){
        $noclient = ClientHistory::find($id);
        return view('emails.noclient_edit', compact('noclient'));
    }
    public function noclient_update(Request $request, $id){
        $noclient = ClientHistory::find($id);
        $noclient->client_id = $request->client_id;
        $noclient->save();
        return redirect()->action('\App\Http\Controllers\EmailController@noclient');
    }
    public function ignored_email()
    {
        $Title = "Ignored Emails";
        $ignored_emails = Ignored_Email::all();
        return view('emails.ignored_email', compact('Title', 'ignored_emails'));
    }
    public function ignored_email_update(Request $request, $id)
    {
        $ignored_email = Ignored_Email::find($id);
        $ignored_email->email = $request->email;
        $ignored_email->save();
        return redirect()->action('\App\Http\Controllers\EmailController@ignored_email');
    }
    public function ignored_email_create(Request $request)
    {
        $ignored_email = new Ignored_Email();
        $ignored_email->email = $request->email;
        $ignored_email->save();
        return redirect()->action('\App\Http\Controllers\EmailController@ignored_email');
    }
    public function ignored_email_delete($id){
        Ignored_Email::where('id', $id)->delete();
        return redirect()->action('\App\Http\Controllers\EmailController@ignored_email');
    }
}