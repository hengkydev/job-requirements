<?php

class SuperuserRolesGiveModel extends MY_Model
{
    protected $table 	= "superusers_roles_give";

	public function role()
	{
		return $this->hasOne('SuperuserRolesModel', 'id','roles_id');
	}

	public function superuser()
	{
		return $this->hasOne('SuperuserModel', 'id','superuser_id');
	}
}
