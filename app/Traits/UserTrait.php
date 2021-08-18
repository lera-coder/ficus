<?php


namespace App\Traits;


use App\Models\Email;
use App\Models\Phone;
use App\Models\PhoneCountryCode;
use Exception;

trait  UserTrait
{


    /**********************************Phones and emails different requests****************************/



    /**
     * Function, that returns just active email of this user
     * @return mixed
     */
    public function activeEmail(){
        return $this->emails->where('is_active', 1)->first();
    }




    /**
     * Function, that returns just active phone of this user
     * @return mixed
     */
    public function activePhone(){
        return $this->phones->where('is_active', 1)->first();
    }

    /**
     * Function, that returns non active emails of this user
     * @return mixed
     */
    public function disactiveEmails(){
        return $this->emails->where('is_active', 0);
    }



    /**
     * Function, that returns non active phones of this user
     * @return mixed
     */
    public function disactivePhones(){
        return $this->phones->where('is_active', 0);
    }



    /**
     * Function to get full user's number with country code
     *
     * @return string
     */
    public function getFullActivePhone(){
        $phone = $this->activePhone();
        return $phone->phoneCountryCode->code.$phone->phone_number;
    }


    /**
     * Function to make disactive mail active
     *
     * @param $email_name
     */
    public function makeEmailActive($email_id){

        try {
            $email = Email::find($email_id);
        }
        catch (Exception $e){
            return response('This email is not found!', 404);
        }
        if($email->is_active) return response('This email was already active');

        $this->activeEmail()->is_active = false;
        $this->push();

        $email->is_active = true;
        $email->save();


    }


    /**
     * Function to add Email
     *
     * @param $email_name
     */
    public function addEmail($email_name){

        return $this->emails()->create([
            'email'=>$email_name,
            'is_active'=>$this->emails()->count()==0,
            'user_id'=>$this->id
        ]);
    }


    /**
     * Function to make phone active
     *
     * @param $phone_number
     */
    public function makePhoneActive($phone_id){
        try {
            $phone = Phone::find($phone_id);
        }
        catch (Exception $e){
            return response('This phone is not found!', 404);
        }
        if($phone->is_active) return response('This phone was already active');

        $this->activePhone()->is_active = false;
        $this->push();

        $phone->is_active = true;
        $phone->save();
    }


    /**
     * Function to add phone
     *
     * @param $phone_number
     */
    public function addPhone($phone_number, $country_code){
        return  $this->phones()->create([
            'phone_number'=>$phone_number,
            'is_active'=>$this->phones()->count()==0,
            'phone_country_code_id'=>PhoneCountryCode::where('code',$country_code)->first()->id,
            'user_id'=>$this->id
        ]);

    }





}
