<?php


namespace App\Traits;


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
    public function makeEmailActive($email_name){
        $this->activeEmail()->is_active = false;
        $this->disactiveEmails()->where('email', $email_name)->first()->is_active = true;
        $this->push();
    }


    /**
     * Function to add Email
     *
     * @param $email_name
     */
    public function addEmail($email_name){

        $this->emails()->create([
            'email'=>$email_name,
            'is_active'=>$this->emails()==0,
            'user_id'=>$this->id
        ]);
    }


    /**
     * Function to make phone active
     *
     * @param $phone_number
     */
    public function makePhoneActive($phone_number){
        $this->activePhone()->is_active = false;
        $this->disactivePhones()->where('email', $phone_number)->first()->is_active = true;
        $this->push();
    }


    /**
     * Function to add phone
     *
     * @param $phone_number
     */
    public function addPhone($phone_number){
        $this->phones()->create([
            'email'=>$phone_number,
            'is_active'=>$this->phones()==0,
            'user_id'=>$this->id
        ]);
    }



}
