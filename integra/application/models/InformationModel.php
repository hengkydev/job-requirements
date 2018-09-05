<?php

class InformationModel extends MY_Model
{
    protected $table 	= "information";
	protected $appends 	= ['logo_dir','logo_white_dir','logo_dark_dir','icon_dir','icon_white_dir','icon_dark_dir'];


	public function getLogodirAttribute(){
		return imgContentRender('logo',$this->logo);
	}

	public function getLogodarkdirAttribute(){
		return imgContentRender('logo',$this->logo_dark);
	}

	public function getLogowhitedirAttribute(){
		return imgContentRender('logo',$this->logo_white);
	}

	public function getIcondirAttribute(){
		return imgContentRender('icon',$this->icon);
	}

	public function getIcondarkdirAttribute(){
		return imgContentRender('icon',$this->icon_dark);
	}

	public function getIconwhitedirAttribute(){

		return imgContentRender('icon',$this->icon_white);
	}

	public function scopeIsMaintenance($query){
		return $query->where("status",'=','maintenance');
	}

	
}
